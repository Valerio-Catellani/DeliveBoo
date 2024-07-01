import Chart from 'chart.js/auto'

const ColumnChart = (async function () {
    const data = [
        { year: 2010, count: 10 },
        { year: 2011, count: 20 },
        { year: 2012, count: 15 },
        { year: 2013, count: 25 },
        { year: 2014, count: 22 },
        { year: 2015, count: 30 },
        { year: 2016, count: 28 },
    ];

    new Chart(
        document.getElementById('acquisitions'),
        {
            type: 'bar',
            data: {
                labels: data.map(row => row.year),
                datasets: [
                    {
                        label: 'Acquisitions by year',
                        data: data.map(row => row.count)
                    }
                ]
            }
        }
    );
});






const DonatChart = (async function () {
    const data = {
        labels: [
            'Red',
            'Green',
            'Yellow',
            'Grey',
            'Blue'
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [11, 16, 7, 3, 14],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(75, 192, 192)',
                'rgb(255, 205, 86)',
                'rgb(201, 203, 207)',
                'rgb(54, 162, 235)'
            ]
        }]
    };

    new Chart(
        document.getElementById('acquisitions-donat'),
        {
            type: 'polarArea',
            data: data,
            options: {}
        }
    );
});





const LineChart = (async function () {
    const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];
    const data = {
        labels: labels,
        datasets: [{
            label: 'My First Dataset',
            data: [65, 59, 80, 81, 56, 55, 40],
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
    try {
        const response = await axios.get('/api/get-orders', {
            params: { month: date, user_id: user_id }
        })
        console.log(response.data);
    } catch {

    }

    console.log(date);
}


export { ColumnChart, DonatChart, LineChart, getData }
