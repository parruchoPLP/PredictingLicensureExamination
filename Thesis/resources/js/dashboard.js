document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('popoverOverlay');
    const popoverCards = [ 
        document.getElementById('popOverallPass'),
        document.getElementById('popFeature'),
        document.getElementById('popTopPredictors'),
        document.getElementById('popAveCourse'),
        document.getElementById('popMetrics'),
    ];

    overlay.style.position = "fixed";
    overlay.style.zIndex = "50";

    popoverCards.forEach((popoverCard, index) => {
        const helpButton = document.getElementById(`helpButton${index + 1}`);

        helpButton.addEventListener('click', (event) => {
            event.preventDefault(); 
            popoverCards.forEach(card => {
                card.classList.add('invisible', 'opacity-0');
            });

            overlay.classList.remove('hidden');
            popoverCard.classList.remove('invisible', 'opacity-0');

            popoverCard.style.left = `50%`;
            popoverCard.style.top = `50%`;
            popoverCard.style.transform = `translate(-50%, -50%)`;
        });
    });

    overlay.addEventListener('click', () => {
        popoverCards.forEach(card => {
            card.classList.add('invisible', 'opacity-0');
        });
        overlay.classList.add('hidden');
    });
});

document.addEventListener('DOMContentLoaded', function () {
    topPredictors.forEach(predictor => {
        const listItem = document.createElement('li');
        listItem.textContent = predictor;
        topPredictorsList.appendChild(listItem);
    });

    const totalTakers = passingRate.total_passed + passingRate.total_failed;
    const pass = (passingRate.total_passed / totalTakers * 100).toFixed(2);
    const fail = (passingRate.total_failed / totalTakers * 100).toFixed(2);

    const getChartOptions = () => {
        return {
            series: [parseFloat(pass), parseFloat(fail)], // Passing and failing rates formatted
            colors: ["#10b981", "#6ee7b7"], // Colors for passing and failing
            chart: {
                height: 420,
                width: "100%",
                type: "donut",
            },
            stroke: {
                colors: ["transparent"],
                lineCap: "round",
            },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                offsetY: 20,
                            },
                            total: {
                                showAlways: true,
                                show: true,
                                label: "Passing Rate",
                                formatter: function () {
                                    return pass + "%"; // Display passing rate with 2 decimal places
                                },
                            },
                            value: {
                                show: true,
                                offsetY: -20,
                                formatter: function (value) {
                                    return parseFloat(value).toFixed(2) + "%"; // Show each section's value as a percentage with 2 decimals
                                },
                            },
                        },
                        size: "70%",
                    },
                },
            },
            grid: {
                padding: {
                    top: -2,
                },
            },
            labels: ["Passing", "Failing"], // Labels for passing and failing
            dataLabels: {
                enabled: false,
            },
            legend: {
                position: "top",
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return parseFloat(value).toFixed(2) + "%";
                    },
                },
            },
            xaxis: {
                labels: {
                    formatter: function (value) {
                        return parseFloat(value).toFixed(2) + "%";
                    },
                },
                axisTicks: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
            },
        };
    };
    
    if (document.getElementById("passingRate-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("passingRate-chart"), getChartOptions());
        chart.render();
    }   

    const importanceData = Object.entries(featureImportance).map(([courseCode, value]) => ({
        x: courseCode,
        y: value,
    }));

    const options = {
        colors: ["#10b981", "#6ee7b7"], // Original colors (if needed, they can be removed)
        series: [
            {
                name: "Feature Importance",
                data: importanceData,
            },
        ],
        chart: {
            type: "bar",
            height: "250px",
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "70%",
                borderRadiusApplication: "end",
                borderRadius: 1,
            },
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(value) {
                    return value.toFixed(4); // Format to 4 decimal places for tooltip values
                },
            },
        },
        states: {
            hover: {
                filter: {
                    type: "darken",
                    value: 1,
                },
            },
        },
        stroke: {
            show: true,
            width: 0,
            colors: ["transparent"],
        },
        grid: {
            show: true,
            strokeDashArray: 4,
            padding: {
                left: 2,
                right: 2,
                top: -14,
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: true,
            position: "top", // Positioning legend at the top
            horizontalAlign: "center", // Centering legend horizontally
        },
        yaxis: {
            labels: {
                formatter: function(value) {
                    return value.toFixed(2); // Format to 2 decimal places on the y-axis labels
                },
                style: {
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                },
            },
        },
        xaxis: {
            floating: false,
            labels: {
                show: true,
                style: {
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                },
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            title: {
                text: "Courses", // Label for x-axis
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    cssClass: 'fill-gray-500 dark:fill-gray-400',
                },
            },
        },
        fill: {
            type: "gradient", // Enable gradient fill
            gradient: {
                shade: "light", // Specify light or dark shade
                type: "horizontal", // Horizontal gradient
                gradientToColors: ["#6ee7b7"], // Emerald green for the gradient end
                stops: [0, 100], // Start and end stops for the gradient
            },
        },
    };

    if (document.getElementById("feature-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("feature-chart"), options);
        chart.render();
    }

    const getRadialChartOptions = () => {
        return {
            series: [modelMetrics.accuracy, modelMetrics.precision, modelMetrics.recall, modelMetrics.f1_score],
            colors: ["#6ee7b7", "#34d399", "#10b981", "#059669"], // Add a color for the fourth metric
            chart: {
                height: "250px",
                width: "100%",
                type: "radialBar",
                sparkline: {
                enabled: true,
                },
            },
            plotOptions: {
                radialBar: {
                track: {
                    background: '#d1fae5',
                },
                dataLabels: {
                    show: false,
                },
                hollow: {
                    margin: 0,
                    size: "10%",
                }
                },
            },
            grid: {
                show: false,
                strokeDashArray: 4,
                padding: {
                left: 2,
                right: 2,
                top: -23,
                bottom: -20,
                },
            },
            labels: ["Accuracy", "Precision", "Recall", "F1 Score"], // Update labels for the metrics
            legend: {
                show: true,
                position: "bottom",
            },
            tooltip: {
                enabled: true,
                x: {
                show: false,
                },
            },
            yaxis: {
                show: false,
                labels: {
                formatter: function (value) {
                    return value + '%';
                }
                }
            }
            }
        }
        
    if (document.getElementById("metrics-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.querySelector("#metrics-chart"), getRadialChartOptions());
        chart.render();
    }
    

    const courseData = Object.entries(averageCourse).map(([courseCode, average]) => ({
        x: courseCode,
        y: average,
    }));
    
    const overallaveperCourseoptions = {
        colors: ["#10b981", "#6ee7b7"], // Original colors (if needed, they can be removed)
        series: [
            {
                name: "Average Per Course",
                data: courseData,
            },
        ],
        chart: {
            type: "bar",
            height: "300px",
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "70%",
                borderRadiusApplication: "end",
                borderRadius: 1,
            },
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(value) {
                    return value.toFixed(2); // Format to 2 decimal places
                },
            },
        },
        yaxis: {
            labels: {
                formatter: function(value) {
                    return value.toFixed(2); // Format to 2 decimal places on the y-axis labels
                },
                style: {
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                },
            },
        },
        states: {
            hover: {
                filter: {
                    type: "darken",
                    value: 1,
                },
            },
        },
        stroke: {
            show: true,
            width: 0,
            colors: ["transparent"],
        },
        grid: {
            show: true,
            strokeDashArray: 4,
            padding: {
                left: 2,
                right: 2,
                top: -14,
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: true,
            position: "top", // Positioning legend at the top
            horizontalAlign: "center", // Centering legend horizontally
        },
        xaxis: {
            floating: false,
            labels: {
                show: true,
                style: {
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                },
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            title: {
                text: "Courses", // Label for x-axis
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    cssClass: 'fill-gray-500 dark:fill-gray-400',
                },
            },
        },
        fill: {
            type: "gradient", // Enable gradient fill
            gradient: {
                shade: "light", // Specify light or dark shade
                type: "horizontal", // Horizontal gradient
                gradientToColors: ["#6ee7b7"], // Emerald green for the gradient end
                stops: [0, 100], // Start and end stops for the gradient
            },
        },
    };
    
    if (document.getElementById("overallaveperCourse-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("overallaveperCourse-chart"), overallaveperCourseoptions);
        chart.render();
    }
});