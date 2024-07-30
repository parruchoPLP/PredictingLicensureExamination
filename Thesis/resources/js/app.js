import './bootstrap';
import 'flowbite';
import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function () {
    // Data placeholders
    const averagePredictionAccuracy = 85; // Example: 85%
    const overallPassingRate = 75; // Example: 75%
    const topPredictors = ['Algebra', 'Trigonometry', 'Calculus']; // Example top 3 predictors
    const precision = 80; // Example: 80%
    const recall = 90; // Example: 90%
    const f1Score = 85; // Example: 85%
    const featureImportanceData = {
        labels: ['Algebra', 'Trigonometry', 'Calculus', 'Physics', 'Chemistry'],
        values: [0.465, 0.397, 0.385, 0.340, 0.387] // Example values
    };

    const topPredictorsList = document.getElementById('topPredictorsList');

    topPredictorsList.innerHTML = '';

    topPredictors.forEach(predictor => {
        const listItem = document.createElement('li');
        listItem.textContent = predictor;
        topPredictorsList.appendChild(listItem);
    });

    const centerTextPlugin = {
        id: 'centerText',
        afterDraw: (chart) => {
            const { width, height, ctx } = chart;
            const { id } = chart.canvas;

            if (id === 'overallPassingRateChart' || id === 'averagePredictionAccuracyChart' ||
                id === 'precisionChart' || id === 'recallChart' || id === 'f1ScoreChart') {
                ctx.restore();
                const fontSize = (height / 114).toFixed(2);
                ctx.font = `bold ${fontSize}em sans-serif`;
                ctx.textBaseline = 'middle';

                let text;
                let textX;
                let textY;

                if (id === 'overallPassingRateChart') {
                    text = `${chart.data.datasets[0].data[0]}%`;
                    textX = Math.round((width - ctx.measureText(text).width) / 2);
                    textY = height / 2;
                } else if (id === 'averagePredictionAccuracyChart' ||
                           id === 'precisionChart' || id === 'recallChart' || id === 'f1ScoreChart') {
                    text = `${chart.data.datasets[0].data[0]}%`;
                    textX = Math.round((width - ctx.measureText(text).width) / 2);
                    textY = height * 0.75; 
                }

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
    };

    Chart.register(centerTextPlugin);

    // Average Prediction Accuracy Doughnut Chart
    const ctx1 = document.getElementById('averagePredictionAccuracyChart').getContext('2d');
    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Accuracy', 'Remaining'],
            datasets: [{
                data: [averagePredictionAccuracy, 100 - averagePredictionAccuracy],
                backgroundColor: ['#34D399', '#A7F3D0']
            }]
        },
        options: {
            responsive: true,
            cutout: '50%', 
            rotation: -90, 
            circumference: 180, 
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + '%';
                        }
                    }
                },
                centerText: {
                    display: true,
                    text: `${averagePredictionAccuracy}%`
                }
            }
        }
    });

    // Overall Passing Rate Doughnut Chart
    const ctx2 = document.getElementById('overallPassingRateChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Passing Rate', 'Remaining'],
            datasets: [{
                data: [overallPassingRate, 100 - overallPassingRate],
                backgroundColor: ['#34D399', '#A7F3D0']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + '%';
                        }
                    }
                },
                centerText: {
                    display: true,
                    text: `${overallPassingRate}%`
                }
            }
        }
    });

    // Precision Doughnut Chart
    const ctx3 = document.getElementById('precisionChart').getContext('2d');
    new Chart(ctx3, {
        type: 'doughnut',
        data: {
            labels: ['Precision', 'Remaining'],
            datasets: [{
                data: [precision, 100 - precision],
                backgroundColor: ['#34D399', '#A7F3D0']
            }]
        },
        options: {
            responsive: true,
            cutout: '50%', 
            rotation: -90, 
            circumference: 180, 
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + '%';
                        }
                    }
                },
                centerText: {
                    display: true,
                    text: `${precision}%`
                }
            }
        }
    });

    // Recall Doughnut Chart
    const ctx4 = document.getElementById('recallChart').getContext('2d');
    new Chart(ctx4, {
        type: 'doughnut',
        data: {
            labels: ['Recall', 'Remaining'],
            datasets: [{
                data: [recall, 100 - recall],
                backgroundColor: ['#34D399', '#A7F3D0']
            }]
        },
        options: {
            responsive: true,
            cutout: '50%', 
            rotation: -90, 
            circumference: 180, 
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + '%';
                        }
                    }
                },
                centerText: {
                    display: true,
                    text: `${recall}%`
                }
            }
        }
    });

    // F1 Score Doughnut Chart
    const ctx5 = document.getElementById('f1ScoreChart').getContext('2d');
    new Chart(ctx5, {
        type: 'doughnut',
        data: {
            labels: ['F1 Score', 'Remaining'],
            datasets: [{
                data: [f1Score, 100 - f1Score],
                backgroundColor: ['#34D399', '#A7F3D0']
            }]
        },
        options: {
            responsive: true,
            cutout: '50%', 
            rotation: -90, 
            circumference: 180, 
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw + '%';
                        }
                    }
                },
                centerText: {
                    display: true,
                    text: `${f1Score}%`
                }
            }
        }
    });

    // Feature Importance Bar Chart
    const ctx6 = document.getElementById('featureImportanceChart').getContext('2d');
    new Chart(ctx6, {
        type: 'bar',
        data: {
            labels: featureImportanceData.labels,
            datasets: [{
                label: 'Feature Importance',
                data: featureImportanceData.values,
                backgroundColor: '#34D399',
                borderRadius: 100
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.raw;
                        }
                    }
                },
                centerText: {
                    display: false 
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value;
                        }
                    }
                }
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const passFailData = {
        pass: 16, // Example number of passes
        fail: 24,  // Example number of fails
    };

    const passPercentage = (passFailData.pass / (passFailData.pass + passFailData.fail) * 100).toFixed(2);
    const failPercentage = (passFailData.fail / (passFailData.pass + passFailData.fail) * 100).toFixed(2);

    const ctx = document.getElementById('passFailRateChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pass', 'Fail'],
            datasets: [{
                data: [passFailData.pass, passFailData.fail],
                backgroundColor: ['#34D399', '#F87171'],
                borderColor: ['#FFFFFF', '#FFFFFF'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw}`;
                        }
                    }
                }
            }
        }
    });

    const passFailLegend = document.getElementById('passFailLegend');
    passFailLegend.innerHTML = `
        <li class="flex items-center">
            <div class="w-4 h-4 bg-[#34D399] mr-2"></div>
            <span>Predicted to pass: ${passFailData.pass} (${passPercentage}%)</span>
        </li>
        <li class="flex items-center mt-2">
            <div class="w-4 h-4 bg-[#F87171] mr-2"></div>
            <span>Predicted to fail: ${passFailData.fail} (${failPercentage}%)</span>
        </li>
    `;
});