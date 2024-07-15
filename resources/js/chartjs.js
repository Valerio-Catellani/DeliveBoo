import Chart from 'chart.js/auto'

let info = {
    total_number_of_orders: 0,
    total_gain: 0,
    total_gain_year: 0,          // Nuova proprietà
    total_orders_year: 0,        // Nuova proprietà
    orders: {},
    dishes: {},
    ordersByYear: [],
    arrayOfDishes: '',
}

const charts = {
    column: '',
    columnYear: '',
    donat: '',
    line: '',
    lineYear: '',
}

function convertDateToItalianFormat(dateString) {
    const [year, month, day] = dateString.split('-');
    return `${day} / ${month}`;
}


const ColumnChart = (async function () {
    if (charts.column) {
        charts.column.destroy();
        charts.column = '';
        ColumnChart();
    } else {
        const data = Object.entries(info.orders).map(([day, order]) => ({
            day: convertDateToItalianFormat(day),
            count: order.number_of_orders
        }));;

        charts.column = new Chart(
            document.getElementById('acquisitions'),
            {
                type: 'bar',
                data: {
                    labels: data.map(row => row.day),
                    datasets: [
                        {
                            label: 'Ordinazioni per Giorno',
                            data: data.map(row => row.count)
                        }
                    ]
                }
            }
        );

    }


});

const ColumnChartYear = (async function () {
    if (charts.columnYear) {
        charts.columnYear.destroy();
        charts.columnYear = '';
        ColumnChartYear();
    } else {


        charts.columnYear = new Chart(
            document.getElementById('acquisitionsYear'),
            {
                type: 'bar',
                data: {
                    labels: info.ordersByYear.map(row => `${row.month} ${row.year}`),
                    datasets: [
                        {
                            label: 'Ordinazioni per Mese',
                            data: info.ordersByYear.map(row => row.number_of_orders),
                            backgroundColor: 'rgba(255, 0, 0, 0.2)',
                            borderColor: 'rgba(255, 0, 0, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );
    }
});


const LineChart = (async function () {
    if (charts.line) {
        charts.line.destroy();
        charts.line = '';
        LineChart();
    } else {
        const labels = Object.values(info.orders).map(order => order.day_of_ordination);

        const data = {
            labels: labels,
            datasets: [{
                label: 'Entrate Giornaliere',
                data: Object.values(info.orders).map(order => order.total_price),
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        }

        charts.line = new Chart(
            document.getElementById('acquisitions-line'),
            {
                type: 'line',
                data: data
            }
        );
    }

})

const LineChartYear = (async function () {
    if (charts.lineYear) {
        charts.lineYear.destroy();
        charts.lineYear = '';
        LineChartYear();
    } else {
        const data = info.ordersByYear;
        const labels = data.map(entry => `${entry.month} ${entry.year}`);
        const totalPriceData = data.map(entry => parseFloat(entry.total_price));

        const chartData = {
            labels: labels,
            datasets: [{
                label: 'Entrate Mensili',
                data: totalPriceData,
                fill: false,
                borderColor: 'rgb(255, 0, 0)',
                tension: 0.1
            }]
        }

        charts.lineYear = new Chart(
            document.getElementById('acquisitions-line-Year'),
            {
                type: 'line',
                data: chartData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            }
        );
    }
});


function reset() {
    info = {
        total_number_of_orders: 0,
        total_gain: 0,
        orders: {},
        dishes: {}
    }

    document.querySelectorAll('.loader-container').forEach((element) => {
        element.classList.remove('d-none');
    })

    document.querySelectorAll('.chart-to-update').forEach((element) => {
        element.classList.add('d-none');
    })

    document.querySelectorAll('.fst-italic-update').forEach((element) => {
        element.classList.add('d-none');
    })

    document.getElementById('dishes-table').innerHTML = '';
    document.getElementById('chartjs-date-picker').disabled = true;


}



async function getData(month = new Date().getMonth() + 1, year = new Date().getFullYear()) {

    reset();

    let params = {
        user_id: document.getElementById('dashboard').getAttribute('data-user-id'),
        month: month,
        year: year
    }

    function getDaysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    function calcolaOrdiniTotali(orders) {
        let totaleOrdini = 0;

        for (let data in orders) {
            if (orders.hasOwnProperty(data)) {
                totaleOrdini += orders[data].number_of_orders;
            }
        }

        return totaleOrdini;
    }

    function calcolaGuadagniTotali(orders) {
        let totaleGuadagni = 0;

        for (let data in orders) {
            if (orders.hasOwnProperty(data)) {
                totaleGuadagni += parseFloat(orders[data].total_price);
            }
        }

        return totaleGuadagni;
    }

    // Ottieni il numero di giorni nel mese corrente
    const daysInMonth = getDaysInMonth(month, year);

    // Crea un oggetto con le date del mese corrente come chiavi
    for (let day = 1; day <= daysInMonth; day++) {
        const dayString = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        info.orders[dayString] = {
            number_of_orders: 0,
            total_price: 0,
            day_of_ordination: convertDateToItalianFormat(dayString)
        };
    }

    try {
        const response = await axios.get('/api/get-orders', {
            params
        })
        const responseYear = await axios.get('/api/get-orders-by-month', {
            params
        })
        const respYear = responseYear.data.results;
        info.ordersByYear = respYear;
        const resp = response.data.results;
        info.total_gain = resp.total_price;

        for (let day = 1; day <= daysInMonth; day++) {
            const dayString = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            resp.number_of_orders.forEach(order => {
                if (order.day === dayString) {
                    info.orders[dayString].day_of_ordination = convertDateToItalianFormat(dayString);
                    info.orders[dayString].number_of_orders = order.number_of_orders;
                    info.orders[dayString].total_price = order.total_price;
                }
            });
        }

        resp.dishes.forEach(dish => {
            if (!info.dishes[dish.name]) {
                info.dishes[dish.name] = {
                    'name': dish.name,
                    'numbers_of_ordinations': 0,
                    'image': dish.image,
                    'id': dish.id
                };
            }

            dish.orders.forEach(order => {
                info.dishes[dish.name].numbers_of_ordinations += order.dish_quantity;
            });
        });

        const orderDish = Object.entries(info.dishes);
        orderDish.sort((a, b) => b[1].numbers_of_ordinations - a[1].numbers_of_ordinations);
        info.arrayOfDishes = orderDish;

        info.total_number_of_orders = calcolaOrdiniTotali(info.orders);

        // Calcola i guadagni totali annuali
        info.total_gain_year = respYear.reduce((total, current) => total + parseFloat(current.total_price), 0);
        info.total_orders_year = respYear.reduce((total, current) => total + current.number_of_orders, 0);

        document.getElementById('total_price').innerHTML = `Guadagni Totali Mensili:  ${info.total_gain} €`;
        document.getElementById('total_ordinations').innerHTML = `Ordinazioni Totali Mensili:  ${info.total_number_of_orders}`;
        document.querySelectorAll('.current_month').forEach((element) => {
            element.innerHTML = convertiData(month, year);
        });
        document.querySelectorAll('.chart').forEach((element) => {
            element.classList.remove('d-none');
        });

        ColumnChart();
        LineChart();
        dishesTable();

        // Visualizza i guadagni totali annuali e gli ordini totali annuali
        document.getElementById('total_price_year').innerHTML = `Guadagni Totali Annuali:  ${info.total_gain_year} €`;
        document.getElementById('total_ordinations_year').innerHTML = `Ordinazioni Totali Annuali:  ${info.total_orders_year}`;

    } catch (error) {
        console.error(error);
    } finally {
        document.querySelectorAll('.loader-container').forEach((element) => {
            element.classList.add('d-none');
        });
        document.querySelectorAll('.fst-italic').forEach((element) => {
            element.classList.remove('d-none');
        });
        document.getElementById('chartjs-date-picker').disabled = false;
    }
}


const mesiInItaliano = [
    "gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno",
    "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre"
];

// Funzione per convertire il formato di data
function convertiData(mese, anno) {
    // Il mese nell'array è zero-indexed, quindi dobbiamo sottrarre 1
    const nomeMese = mesiInItaliano[mese - 1];
    return `${nomeMese} ${anno}`;
}

function dishesTable() {
    const container = document.getElementById('dishes-table');
    const table = document.createElement('table');
    table.classList.add('table', 'table-bordered', 'table-striped', 'text-center', 'hype-unselectable', 'table-hover');
    table.innerHTML = `
        <thead>
            <tr>
                <th>Immagine</th>
                <th>Nome</th>
                <th>Numero Ordinazioni</th>
            </tr>
        </thead>
    `;
    let tmp = '';
    if (info.arrayOfDishes.length > 0) {
        for (let i = 0; i < (info.arrayOfDishes.length > 5 ? 5 : info.arrayOfDishes.length); i++) {
            tmp += `
                <tr>
                    <td style="width: 50px"><img src="${info.arrayOfDishes[i][1].image}" class="img-fluid mx-auto" style="width: 50px; height: 50px;"></td>
                    <td>${info.arrayOfDishes[i][1].name}</td>
                    <td>${info.arrayOfDishes[i][1].numbers_of_ordinations}</td>
                </tr>
            `
        };
        table.innerHTML += tmp;
        container.appendChild(table);
    } else {
        container.innerHTML = `<p class="fst-italic text-center fs-5">Nessun elemento da mostrare</p>`
    }
}


export { getData, ColumnChartYear, LineChartYear };
