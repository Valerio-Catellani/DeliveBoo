import Chart from 'chart.js/auto'

const info = {
    total_gain: 0,
    orders: {},
    dishes: {}
}


function convertDateToItalianFormat(dateString) {
    const [year, month, day] = dateString.split('-');
    return `${day} / ${month}`;
}


const ColumnChart = (async function () {

    const data = Object.entries(info.orders).map(([day, order]) => ({
        day: convertDateToItalianFormat(day),
        count: order.number_of_orders
    }));;

    new Chart(
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
});

async function loadImage(src) {
    return new Promise((resolve) => {
        const img = new Image();
        img.onload = () => resolve(img);
        img.src = src;
    });
}

const DonatChart = (async function () {
    const entries = Object.values(info.dishes);
    const images = await Promise.all(entries.map(entry => loadImage(entry.image)));

    const data = {
        labels: entries.map(entry => entry.name),
        datasets: [{
            label: 'Ordinazioni per Piatti',
            data: entries.map(entry => entry.numbers_of_ordinations),
            backgroundColor: images.map(img => {
                const pattern = document.createElement('canvas').getContext('2d').createPattern(img, 'repeat');
                return pattern;
            })
        }]
    };

    const ctx = document.getElementById('acquisitions-donat').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true
                }
            },
            elements: {
                arc: {
                    backgroundColor: (ctx) => {
                        const index = ctx.dataIndex;
                        const img = images[index];
                        const pattern = ctx.chart.ctx.createPattern(img, 'repeat');
                        return pattern;
                    }
                }
            }
        }
    });
})



const LineChart = (async function () {
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

    new Chart(
        document.getElementById('acquisitions-line'),
        {
            type: 'line',
            data: data
        }
    );
})

async function getData() {

    const date = new Date().getMonth() + 1;
    const user_id = document.getElementById('dashboard').getAttribute('data-user-id');
    console.log(user_id);

    function getDaysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    // Ottieni il numero di giorni nel mese corrente
    const year = new Date().getFullYear();
    const daysInMonth = getDaysInMonth(date, year);

    // Crea un oggetto con le date del mese corrente come chiavi
    for (let day = 1; day <= daysInMonth; day++) {
        const dayString = `${year}-${String(date).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        info.orders[dayString] = {
            number_of_orders: 0,
            total_price: 0,
            day_of_ordination: convertDateToItalianFormat(dayString)
        };
    }


    try {
        const response = await axios.get('/api/get-orders', {
            params: { month: date, user_id: user_id }
        })
        const resp = response.data.results
        info.total_gain = resp.total_price;

        for (let day = 1; day <= daysInMonth; day++) {
            const dayString = `${year}-${String(date).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            resp.number_of_orders.forEach(order => {
                if (order.day === dayString) {
                    info.orders[dayString].day_of_ordination = convertDateToItalianFormat(dayString)
                    info.orders[dayString].number_of_orders = order.number_of_orders //! afgggiungi la logica qui
                    info.orders[dayString].total_price = order.total_price //! afgggiungi la logica qui
                }
            })
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
        console.log(info);
        document.getElementById('total_price').innerHTML = `Guadagni Totali Mensili:  ${info.total_gain} €`
    } catch {

    }
}


export { ColumnChart, DonatChart, LineChart, getData }
