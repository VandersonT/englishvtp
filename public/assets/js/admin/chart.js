/*Chart1*/

if(savedValue1 != "undefined"){
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
                    '#0C7C59',
                    '#D64933'
                ],
                borderColor: [
                    '#2E4057',
                    '#2E4057',
                    '#2E4057'
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
}

/*Chart2*/
if(studiedName1 != 'undefined'){
    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart2 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [studiedName1, studiedName2, studiedName3],
            datasets: [{
                label: '# de votos',
                data: [studiedValue1, studiedValue2, studiedValue3],
                backgroundColor: [
                    '#58A4B0',
                    '#CDC392',
                    '#FF66B3'
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
}

/*Chart3*/

if(american != 'undefined' && british != 'undefined'){
    var ctx = document.getElementById('myChart3').getContext('2d');
    var myChart3 = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Americano', 'Britânico'],
            datasets: [{
                label: '# de votos',
                data: [american, british],
                backgroundColor: [
                    '#2E4057',
                    '#F18F01'
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
}