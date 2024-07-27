@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section id="dashboard" class="bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-200 min-h-screen pr-32 pl-48 py-24 font-arial">
    <h1 class="text-4xl font-bold"> Welcome, Dean! </h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-10">
        <div class="bg-cyan-50 dark:bg-cyan-800 p-10 rounded-xl shadow-lg flex items-center justify-center overflow-auto max-h-[300px] transition-transform transform hover:scale-105">
            <canvas id="averagePredictionAccuracyChart" class="max-w-[130px] max-h-[130px]"></canvas>
            <h2 class="text-2xl font-bold ml-5">Average Prediction Accuracy</h2>
        </div>
        <div class="bg-emerald-50 dark:bg-green-800 p-10 rounded-xl shadow-lg flex items-center justify-center overflow-auto max-h-[300px] transition-transform transform hover:scale-105">
            <canvas id="overallPassingRateChart" class="max-w-[130px] max-h-[130px]"></canvas>
            <h2 class="text-2xl font-bold ml-5">Overall Passing Rate</h2>
        </div>
        <div class="bg-lime-50 p-10 dark:bg-slate-700 rounded-xl shadow-lg flex flex-col justify-center overflow-auto max-h-[300px] transition-transform transform hover:scale-105">
            <h2 class="text-2xl font-bold">Top Licensure Outcome Predictor</h2>
            <p id="topPredictor" class="text-2xl mt-3">Placeholder Predictor</p>
        </div>
    </div>
    <h2 class="text-2xl font-bold text-center mt-14 mb-8">Feature Importance</h2>
    <div class="bg-white dark:bg-slate-700 p-8 rounded-xl shadow-lg relative overflow-auto">
        <canvas id="featureImportanceChart" style="max-width: 100%;"></canvas>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data placeholders
        const averagePredictionAccuracy = 85; // Example: 85%
        const overallPassingRate = 75; // Example: 75%
        const topPredictor = 'Algebra'; // Example: Algebra
        const featureImportanceData = {
            labels: ['Algebra', 'Trigonometry', 'Calculus', 'Physics', 'Chemistry'],
            values: [0.25, 0.20, 0.15, 0.10, 0.30] // Example values
        };
        // Custom plugin to display text in the center of the doughnut chart
        const centerTextPlugin = {
            id: 'centerText',
            afterDraw: (chart) => {
                if (chart.config.type === 'doughnut') {
                    const { width, height, ctx } = chart;
                    ctx.restore();
                    const fontSize = (height / 114).toFixed(2);
                    ctx.font = `bold ${fontSize}em sans-serif`;
                    ctx.textBaseline = 'middle';
                    const text = `${chart.data.datasets[0].data[0]}%`;
                    const textX = Math.round((width - ctx.measureText(text).width) / 2);
                    const textY = height / 2;
                    ctx.fillText(text, textX, textY);
                    ctx.save();
                }
            }
        };
        // Register the plugin
        Chart.register(centerTextPlugin);
        // Average Prediction Accuracy Doughnut Chart
        const ctx1 = document.getElementById('averagePredictionAccuracyChart').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Accuracy', 'Remaining'],
                datasets: [{
                    data: [averagePredictionAccuracy, 100 - averagePredictionAccuracy],
                    backgroundColor: ['#22D3EE', '#A5F3FC']
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
        // Set the top predictor
        document.getElementById('topPredictor').textContent = topPredictor;
        // Feature Importance Bar Chart
        const ctx3 = document.getElementById('featureImportanceChart').getContext('2d');
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: featureImportanceData.labels,
                datasets: [{
                    label: 'Feature Importance',
                    data: featureImportanceData.values,
                    backgroundColor: '#99F6E4',
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
                                return context.label + ': ' + (context.raw * 100).toFixed(2) + '%';
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
                                return value * 100 + '%';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
