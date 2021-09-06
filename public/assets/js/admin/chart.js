/*Chart1*/
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [savedName1, savedName2, savedName3],
        datasets: [{
            label: '# de votos',
            data: [savedValue1, savedValue2, savedValue3],
            backgroundColor: [
                '#00CED1',
                '#00CED1',
                '#00CED1'
            ],
            borderColor: [
                '#076e63',
                '#076e63',
                '#076e63'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

/*Chart2*/
var ctx = document.getElementById('myChart2').getContext('2d');
var myChart2 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [studiedName1, studiedName2, studiedName3],
        datasets: [{
            label: '# de votos',
            data: [studiedValue1, studiedValue2, studiedValue3],
            backgroundColor: [
                '#0000CD',
                '#0000CD',
                '#0000CD'
            ],
            borderColor: [
                '#0d0638',
                '#0d0638',
                '#0d0638'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

/*Chart3*/
var ctx = document.getElementById('myChart3').getContext('2d');
var myChart2 = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Americano', 'Britânico'],
        datasets: [{
            label: '# de votos',
            data: [american, british],
            backgroundColor: [
                '#0000CD',
                '#1E90FF'
            ],
            borderColor: [
                'gray',
                'gray'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});