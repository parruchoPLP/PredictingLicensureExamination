import './bootstrap';
import 'flowbite';
import Chart from 'chart.js/auto';
import './dashboard';

document.addEventListener('DOMContentLoaded', () => {
    const currentPath = window.location.pathname;
    if (currentPath === "/indivReport") {
        const searchInput = document.getElementById('simple-search');
        const suggestionList = document.getElementById('suggestion-list');
        const studReport = document.getElementById('studReport');
        const studentIdDisplay = document.getElementById('studentIdDisplay');
        const searchBtn = document.getElementById('search-btn');

        if (searchInput && suggestionList && studReport && studentIdDisplay && searchBtn) {
            // Show suggestions while typing
            searchInput.addEventListener('input', () => {
                const query = searchInput.value.toLowerCase();
                suggestionList.innerHTML = '';
                if (query) {
                    suggestionList.classList.remove('hidden');
                    studentIds.filter(id => id.includes(query)).forEach(id => {
                        const li = document.createElement('li');
                        li.textContent = id;
                        li.className = 'px-4 py-2 cursor-pointer hover:bg-emerald-200 dark:hover:bg-emerald-600';
                        li.addEventListener('click', () => {
                            searchInput.value = id;
                            suggestionList.classList.add('hidden');
                            studentIdDisplay.textContent = id;
                            studReport.classList.remove('hidden');
                            filterStudent();
                        });
                        suggestionList.appendChild(li);
                    });
                } else {
                    suggestionList.classList.add('hidden');
                }
            });

            searchInput.addEventListener('focus', () => {
                suggestionList.innerHTML = ''; // Clear any existing suggestions
                suggestionList.classList.remove('hidden'); // Show the suggestion list
            
                // Populate the list with all student IDs
                studentIds.forEach(id => {
                    const li = document.createElement('li');
                    li.textContent = id;
                    li.className = 'px-4 py-2 cursor-pointer hover:bg-emerald-200 dark:hover:bg-emerald-600';
                    li.addEventListener('click', () => {
                        searchInput.value = id;
                        suggestionList.classList.add('hidden');
                        studentIdDisplay.textContent = id;
                        studReport.classList.remove('hidden');
                        filterStudent();
                    });
                    suggestionList.appendChild(li);
                });
            });

            searchInput.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    filterStudent(); // Trigger the function
                    suggestionList.classList.add('hidden'); // Hide the suggestion list
                }
            });

            // Search button click handler
            searchBtn.addEventListener('click', () => {
                const query = searchInput.value.trim();
                if (studentIds.includes(query)) {
                    studentIdDisplay.textContent = query;
                    studReport.classList.remove('hidden');
                } else {
                    alert('Student ID not found.');
                }
            });

            // Hide suggestions when input loses focus
            searchInput.addEventListener('blur', () => {
                setTimeout(() => suggestionList.classList.add('hidden'), 200);
            });
        }
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const reportDiv = document.getElementById('studReport');
    const studentIdDisplay = document.getElementById('studentIdDisplay');
    const buttons = document.querySelectorAll('.report-toggle-button');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const studentId = this.getAttribute('data-student-id');
            studentIdDisplay.textContent = studentId;

            if (reportDiv.classList.contains('hidden')) {
                reportDiv.classList.remove('hidden');
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const currentPath = window.location.pathname;
    if (currentPath === "/report") {
        const passPercentage = (passFailData.pass / (passFailData.pass + passFailData.fail) * 100).toFixed(2);
        const failPercentage = (passFailData.fail / (passFailData.pass + passFailData.fail) * 100).toFixed(2);

        const ctx = document.getElementById('passFailRateChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['High', 'Low'],
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
                    data: [genderData.male], // Total count for males
                },
                {
                    name: "Females",
                    data: [genderData.female], // Total count for females
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

            const averageData = Object.entries(averageGrades).map(([courseCode, average]) => ({
                x: courseCode,
                y: average,
            }));

            const aveperCourseoptions = {
                colors: ["#10b981", "#6ee7b7"], // Original colors (if needed, they can be removed)
                series: [
                    {
                        name: "Average Per Course",
                        data: averageData,
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
                        show: true,
                        style: {
                            cssClass: 'fill-gray-500 dark:fill-gray-400',
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
            
            if (document.getElementById("aveperCourse-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("aveperCourse-chart"), aveperCourseoptions);
                chart.render();
            }
            
            const supportData = Object.entries(courseSupport).map(([code, average]) => ({
                name: code,
                average: average.toFixed(2),
            }));

            const subjects = supportData;
            
            const tableBody = document.getElementById("support-table-body");
            
            subjects.forEach(subject => {
                const row = document.createElement("tr");
                row.className = "border-b dark:border-slate-600";
                
                const subjectCell = document.createElement("td");
                subjectCell.className = "py-2 px-4";
                subjectCell.textContent = subject.name;
            
                const supportCell = document.createElement("td");
                supportCell.className = "py-2 px-4";
                supportCell.textContent = subject.average;
            
                row.appendChild(subjectCell);
                row.appendChild(supportCell);
                tableBody.appendChild(row);
            });        

        const passFailLegend = document.getElementById('passFailLegend');
        passFailLegend.innerHTML = `
            <li class="flex items-center">
                <div class="w-4 h-4 bg-[#34D399] mr-2"></div>
                <span>Highly Likely to pass: ${passFailData.pass} (${passPercentage}%)</span>
            </li>
            <li class="flex items-center mt-2">
                <div class="w-4 h-4 bg-[#F87171] mr-2"></div>
                <span>Less Likely to pass: ${passFailData.fail} (${failPercentage}%)</span>
            </li>
        `;

        const overlay = document.getElementById('popoverOverlay');
        const popoverCards = [ 
            document.getElementById('popAveCourse'),
            document.getElementById('popCourseSupport'),
        ];

        overlay.style.position = "fixed";
        overlay.style.zIndex = "50";

        popoverCards.forEach((popoverCard, index) => {
            const helpButton = document.getElementById(`infoButton${index + 1}`);

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
    }
});
