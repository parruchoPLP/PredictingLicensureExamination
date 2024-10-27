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
    
    const PLPoptions = {
        xaxis: {
            show: true,
            categories: ['Apr, 2018', 'Oct, 2018', 'Apr, 2019', 'Oct, 2019', 'Oct, 2022', 'Apr, 2023', 'Oct, 2023'],
            labels: {
                show: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500'
                }
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
        },
        yaxis: {
            show: true,
            labels: {
                show: true,
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500'
                },
                formatter: function (value) {
                    return value + '%';
                }
            }
        },
        series: [
            {
                name: "National Passing Rate",
                data: ['45.36', '49.49', '48.92', '49.43', '29.69', '33.49', '29.69'],
                color: "#10b981",
            },
            {
                name: "PLP Passing Rate",
                data: ['53.85', '61.11', '33.33', '66.67', '16.67', '20.00', '16.67'],
                color: "#6ee7b7",
            },
        ],
        chart: {
            sparkline: {
                enabled: false
            },
            height: "100%",
            width: "100%",
            type: "area",
            fontFamily: "Inter, sans-serif",
            dropShadow: {
                enabled: false,
            },
            toolbar: {
                show: false,
            },
        },
        tooltip: {
            enabled: true,
            x: {
                show: false,
            },
        },
        fill: {
            type: "gradient",
            gradient: {
                opacityFrom: 0.55,
                opacityTo: 0,
                shade: "#1C64F2",
                gradientToColors: ["#1C64F2"],
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: 6,
        },
        legend: {
            show: false
        },
        grid: {
            show: false,
        },
    };

    if (document.getElementById("labels-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("labels-chart"), PLPoptions);
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