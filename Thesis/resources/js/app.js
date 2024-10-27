import './bootstrap';
import 'flowbite';
import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
    const popovers = document.querySelectorAll('[data-popover-target]');
    
    popovers.forEach(button => {
        const popoverId = button.getAttribute('data-popover-target');
        const popover = document.getElementById(popoverId);

        button.addEventListener('mouseover', (event) => {
            popover.style.left = `${event.currentTarget.offsetLeft}px`;
            popover.style.top = `${event.currentTarget.offsetTop + event.currentTarget.offsetHeight}px`;
            popover.classList.remove('invisible', 'opacity-0');
        });

        button.addEventListener('mouseout', () => {
            popover.classList.add('invisible', 'opacity-0');
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const topPredictors = ['ECE 111', 'ECE 151', 'ECE 114', 'ECE 162', 'ECE 143']; // Example top 3 predictors

    const topPredictorsList = document.getElementById('topPredictorsList');

    topPredictorsList.innerHTML = '';

    topPredictors.forEach(predictor => {
        const listItem = document.createElement('li');
        listItem.textContent = predictor;
        topPredictorsList.appendChild(listItem);
    });

    const getChartOptions = () => {
        return {
            series: [75, 25], // 75% passing, 25% failing
            colors: ["#10b981", "#6ee7b7"], // Color for passing and failing
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
                                    return "75%"; // Display only the passing rate
                                },
                            },
                            value: {
                                show: true,
                                offsetY: -20,
                                formatter: function (value) {
                                    return value + "%"; // Show each section's value as a percentage
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
                        return value + "%";
                    },
                },
            },
            xaxis: {
                labels: {
                    formatter: function (value) {
                        return value + "%";
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

    const options = {
        colors: ["#10b981", "#6ee7b7"], // Original colors (if needed, they can be removed)
        series: [
            {
                name: "Feature Importance",
                data: [
                    { x: "ECE 111", y: 0.10 },
                    { x: "ECE 112", y: 0.15 },
                    { x: "ECE 114", y: 0.05 },
                    { x: "ECE 121", y: 0.20 },
                    { x: "ECE 122", y: 0.30 },
                    { x: "ECE 131", y: 0.40 },
                    { x: "ECE 132", y: 0.25 },
                    { x: "ECE 133", y: 0.35 },
                    { x: "ECE 141", y: 0.20 },
                    { x: "ECE 143", y: 0.30 },
                    { x: "ECE 142", y: 0.15 },
                    { x: "ECE 146", y: 0.25 },
                    { x: "ECE 152", y: 0.40 },
                    { x: "ECE 153", y: 0.30 },
                    { x: "ECE 156", y: 0.10 },
                    { x: "ECE 151", y: 0.45 },
                    { x: "ECE 154", y: 0.20 },
                    { x: "ECE 158", y: 0.35 },
                    { x: "ECE 155", y: 0.25 },
                    { x: "ECE 162", y: 0.30 },
                    { x: "ECE 160", y: 0.15 },
                    { x: "ECE 163", y: 0.40 },
                    { x: "ECE 164", y: 0.10 },
                    { x: "ECE 166", y: 0.50 },
                    { x: "ECE 167", y: 0.30 },
                    { x: "ECE 168", y: 0.20 },
                    { x: "ECE 202", y: 0.25 },
                ],
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
            intersect: false
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
            }
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
                    cssClass: 'fill-gray-500 dark:fill-gray-400'
                },
            },
        },
        yaxis: {
            labels: {
                show: true,
                style: {
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
            series: [90, 85, 70, 75], // Update this to include values for Accuracy, Precision, Recall, and F1 Score
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
            categories: ['Apr, 2017', 'Oct, 2017', 'Apr, 2018', 'Oct, 2018', 'Apr, 2019', 'Oct, 2019', 'Oct, 2022', 'Apr, 2023', 'Oct, 2023'],
            labels: {
                show: true,
                style: {
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
                data: ['41.27', '46.72', '45.36', '49.49', '48.92', '49.43', '29.69', '33.49', '29.69'],
                color: "#10b981",
            },
            {
                name: "PLP Passing Rate",
                data: ['58.33', '41.67', '53.85', '61.11', '33.33', '66.67', '16.67', '20.00', '16.67'],
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

    });

document.addEventListener('DOMContentLoaded', function () {
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

    const genderOptions = {
        series: [
            {
                name: "Males",
                color: "#31C48D",
                data: [7], // Total count for males
            },
            {
                name: "Females",
                data: [5], // Total count for females
                color: "#F05252",
            }
            ],
            chart: {
            sparkline: {
                enabled: false,
            },
            type: "bar",
            width: "100%",
            height: 250,
            toolbar: {
                show: false,
            }
            },
            fill: {
            opacity: 1,
            },
            plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "100%",
                borderRadiusApplication: "end",
                borderRadius: 6,
                dataLabels: {
                position: "top",
                },
            },
            },
            legend: {
            show: true,
            position: "bottom",
            },
            tooltip: {
            shared: true,
            intersect: false,
            formatter: function (value) {
                return value + " students"; // Display student count
            }
            },
            xaxis: {
            labels: {
                show: true,
                style: {
                cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                }
            },
            categories: ["Students"], // Only one category for the total
            axisTicks: {
                show: true,
            },
            axisBorder: {
                show: true,
            },
            },
            yaxis: {
            labels: {
                show: true,
                style: {
                cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                }
            }
            },
            grid: {
            show: true,
            strokeDashArray: 4,
            },
            fill: {
            opacity: 1,
            }
        }
        
        if (document.getElementById("gender-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("gender-chart"), genderOptions);
            chart.render();
        }

        const aveperCourseoptions = {
            colors: ["#10b981", "#6ee7b7"], // Original colors (if needed, they can be removed)
            series: [
                {
                    name: "Average Per Course",
                    data: [
                        { x: "ECE 111", y: 3.0 },
                        { x: "ECE 112", y: 4.0 },
                        { x: "ECE 114", y: 2.5 },
                        { x: "ECE 121", y: 3.8 },
                        { x: "ECE 122", y: 4.2 },
                        { x: "ECE 131", y: 3.5 },
                        { x: "ECE 132", y: 4.0 },
                        { x: "ECE 133", y: 3.2 },
                        { x: "ECE 141", y: 4.1 },
                        { x: "ECE 143", y: 2.9 },
                        { x: "ECE 142", y: 3.6 },
                        { x: "ECE 146", y: 4.3 },
                        { x: "ECE 152", y: 3.7 },
                        { x: "ECE 153", y: 4.5 },
                        { x: "ECE 156", y: 3.0 },
                        { x: "ECE 151", y: 4.8 },
                        { x: "ECE 154", y: 3.9 },
                        { x: "ECE 158", y: 4.1 },
                        { x: "ECE 155", y: 3.4 },
                        { x: "ECE 162", y: 4.6 },
                        { x: "ECE 160", y: 3.1 },
                        { x: "ECE 163", y: 4.0 },
                        { x: "ECE 164", y: 2.8 },
                        { x: "ECE 166", y: 4.9 },
                        { x: "ECE 167", y: 3.3 },
                        { x: "ECE 168", y: 2.7 },
                        { x: "ECE 202", y: 3.6 },
                    ],
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
<<<<<<< Updated upstream
=======
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return value.toFixed(2); // Format to 2 decimal places on the y-axis labels
                    },
                    style: {
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400',
                    }
                },
            },
>>>>>>> Stashed changes
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
        
        if (document.getElementById("aveperCourse-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("aveperCourse-chart"), aveperCourseoptions);
            chart.render();
        }
        
        const subjects = [
            { name: "ECE 143", needsSupport: "True" },
            { name: "ECE 122", needsSupport: "False" },
            { name: "ECE 131", needsSupport: "True" },
            { name: "ECE 114", needsSupport: "False" },
            { name: "ECE 152", needsSupport: "True" },
            // Add more subjects as needed
        ];
        
        const tableBody = document.getElementById("support-table-body");
        
        subjects.forEach(subject => {
            const row = document.createElement("tr");
            row.className = "border-b dark:border-slate-600";
            
            const subjectCell = document.createElement("td");
            subjectCell.className = "py-2 px-4";
            subjectCell.textContent = subject.name;
        
            const supportCell = document.createElement("td");
            supportCell.className = "py-2 px-4";
            supportCell.textContent = subject.needsSupport;
        
            row.appendChild(subjectCell);
            row.appendChild(supportCell);
            tableBody.appendChild(row);
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
