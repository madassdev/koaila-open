import Chart, { elements } from 'chart.js/auto';

function drawChart(canvasElement, data){
    const ctx = document.getElementById(canvasElement);
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: Object.keys(data),
            datasets: [{
                label: 'DAU/MAU',
                data: Object.values(data),

                backgroundColor:[
                    'rgba(255, 159, 64, 1)'
                ],
                borderColor: [
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1,
                pointStyle: 'circle',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            elements:{
                point:{
                    radius:0
                }
            }, 
        }
    });

}

