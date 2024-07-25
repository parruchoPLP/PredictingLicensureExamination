@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section id="dashboard" class="bg-slate-100 min-h-screen py-20 px-20 font-arial ml-60">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white p-4 rounded shadow relative">
                <canvas id="averagePredictionAccuracyChart" style="max-width: 300px; max-height: 300px;"></canvas>
                <div class="absolute inset-0 flex items-center justify-center">
                    <h2 class="text-2xl font-bold">Average Prediction Accuracy</h2>
                </div>
            </div>
            <div class="bg-white p-4 rounded shadow relative">
                <canvas id="overallPassingRateChart" style="max-width: 300px; max-height: 300px;"></canvas>
                <div class="absolute inset-0 flex items-center justify-center">
                    <h2 class="text-2xl font-bold">Overall Passing Rate</h2>
                </div>
            </div>
            <div class="bg-white p-4 rounded shadow flex items-center justify-center">
                <div>
                    <h2 class="text-3xl font-bold">Top Licensure Outcome Predictor</h2>
                    <p id="topPredictor" class="text-2xl">Placeholder Predictor</p>
                </div>
            </div>
        </div>
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">Feature Importance</h2>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <canvas id="featureImportanceChart" style="max-width: 100%;"></canvas>
        </div>
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

        // Average Prediction Accuracy Doughnut Chart
        const ctx1 = document.getElementById('averagePredictionAccuracyChart').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Accuracy', 'Remaining'],
                datasets: [{
                    data: [averagePredictionAccuracy, 100 - averagePredictionAccuracy],
                    backgroundColor: ['#4CAF50', '#E0E0E0']
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
                    backgroundColor: ['#2196F3', '#E0E0E0']
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
                    backgroundColor: '#FF9800'
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
