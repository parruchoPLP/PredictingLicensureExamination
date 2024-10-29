@extends('layouts.app')

@section('title', 'Predicting EE Licensure Exam Performance')

<button id="darkmode-toggle" class="fixed bottom-4 right-4 z-20 py-3 px-4 text-2xl text-slate-600 bg-white dark:bg-slate-800 dark:text-emerald-300 shadow-lg rounded-xl hover:bg-slate-200 hover:dark:bg-slate-600 transition-transform transform hover:scale-105">
    <i id="darkmode-icon" class="fa fa-moon"></i>
</button>

@section('content')
<section id="titlePage" class="relative bg-cover bg-center bg-no-repeat font-arial" style="background-image: url('{{ asset('images/bsece.jpg') }}');">
    <div class="absolute inset-0 bg-gradient-to-t from-slate-100 to-slate-100/40 dark:from-slate-900 dark:to-slate-900/60"></div>
    <div class="relative px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-48">
        <h1 class="my-8 text-4xl text-slate-900 dark:text-white font-extrabold md:text-5xl lg:text-6xl">Forecasting Electronics Engineers Licensure Exam Performance</h1>
        <p class="mb-14 text-lg text-slate-800 dark:text-gray-200 lg:text-xl sm:px-16 lg:px-48">Empowering electronics engineering students with early insights, targeted support, and enhanced success.</p>
        <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
            <a href="/login" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center bg-slate-800 text-emerald-400 rounded-lg dark:bg-emerald-300 dark:text-slate-900 transition-transform transform hover:scale-105 cursor-pointer">
                Log in
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
            <a href="#aboutUs" id="learnMoreLink" class="inline-flex justify-center items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-slate-800 dark:text-emerald-200 rounded-lg border-2 border-slate-800 dark:border-emerald-200 hover:text-emerald-400 dark:hover:text-slate-800 hover:bg-slate-800 dark:hover:bg-emerald-300 transition-transform transform hover:scale-105 cursor-pointer">
                Learn more
            </a>  
        </div>
    </div>
</section>
<section id="aboutUs" class="min-h-screen bg-slate-100 dark:bg-slate-900 text-slate-900 dark:text-white pb-36 font-arial">   
    <div class="flex flex-col md:flex-row items-center p-36"> 
        <div class="w-full max-w-3xl md:max-w-4xl bg-slate-200 p-5 rounded-lg shadow-lg dark:bg-slate-700 transition-transform transform hover:scale-105 hover:shadow-2xl cursor-pointer">
            <div class="flex justify-between p-4 md:p-6 pb-0 md:pb-0">
                <div>
                    <h5 class="leading-none text-3xl font-bold pb-2">PLP Electronics Engineers Licensure Exam Performance Chart</h5>
                </div>
            </div>
            <div id="labels-chart" class="px-2.5"></div>
        </div>
        <div class="md:ml-10 max-w-2xl text-justify">
            <p class="text-5xl font-bold mb-6">Background</p>
            <p class="text-lg">The College of Engineering (CoENG) has generally outperformed the national average in the Electronics Engineers Licensure Examination. From 2018 to 2019, CoENG’s results were consistently better than the national rates, showing strong performance throughout this period. However, there was a dip in early 2019, though CoENG managed to exceed the national average later that year.<br><br>The situation changed significantly with the pandemic, which caused the exams to be canceled in 2020 and 2021. When the exams resumed, CoENG struggled to match its past performance. From 2022 onward, CoENG’s results fell below the national average, highlighting the impact of the pandemic on its performance. Despite some recovery attempts, CoENG’s passing rates remained lower than the national rates in the following years.</p>
        </div>
    </div>
    <div class="mx-36 border-t border-gray-600 mb-24"></div>
    <div class="px-36 text-justify"> 
        <p class="text-5xl font-bold mb-10">Goals</p>
        <p class="text-lg">This system is designed to help the College of Engineering (CoENG) consistently outperform the national average in the Electronics Engineers Licensure Examination. By using a predictive model that analyzes academic performance, demographics, and other key factors, the system seeks to identify promising candidates early on. This will enable targeted interventions to enhance their chances of success and support students who face greater challenges.<br><br>Leveraging advanced machine learning techniques, specifically the Random Forest algorithm, the system provides actionable insights. In doing so, it aims to contribute to PLP’s goal of maintaining high performance and supporting the overall development of its Electronics Engineering students.</p>
    </div>
<div class="mx-36 border-t border-gray-600 my-24"></div>
    <div class="px-36 space-y-10">
        <h1 class="text-5xl font-bold">Our Team</h1>
        <p class="text-lg text-justify">
        Our team is dedicated to the development of a predictive system designed to enhance the performance of Electronics Engineering students at PLP in the Electronics Engineers Licensure Examination. Our objective is to ensure that the College of Engineering (CoENG) consistently surpasses the national average by leveraging advanced data analysis techniques.
        </p>
        <div class="flip-card-container space-x-14">
            <div class="flip-card transition-transform transform hover:scale-105 cursor-pointer">
                <div class="flip-card-inner bg-slate-200 dark:bg-slate-700 shadow-xl">
                        <div class="flip-card-front">
                            <img src="{{ asset('images/lovely.png') }}" alt="Lovely Ann Baylon">
                        </div>
                        <div class="flip-card-back">
                            <p class="text-sm text-center">
                            Lovely Ann Baylon focuses on the design aspects of our system. Her role involves creating a user-friendly interface that facilitates easy interaction with the system and ensures that the visual presentation of data is clear and effective.
                            </p>
                        </div>
                    </div>
                    <p class="name__h1 text-xl text-center font-bold mt-8">Lovely Ann Baylon</p>
                </div>

                <div class="flip-card transition-transform transform hover:scale-105 cursor-pointer">
                    <div class="flip-card-inner bg-slate-200 dark:bg-slate-700 shadow-xl">
                        <div class="flip-card-front">
                            <img src="{{ asset('images/ede.png') }}" alt="Edelyn Carable">
                        </div>
                        <div class="flip-card-back">
                            <p class="text-sm text-center">
                                Edelyn Carable also contributes to the design and usability of the system. Her expertise helps ensure that the system is both functional and aesthetically pleasing, enhancing the user experience.
                            </p>
                        </div>
                    </div>
                    <p class="name__h1 text-xl text-center font-bold mt-8">Edelyn Carable</p>
                </div>

                <div class="flip-card transition-transform transform hover:scale-105 cursor-pointer">
                    <div class="flip-card-inner bg-slate-200 dark:bg-slate-700 shadow-xl">
                        <div class="flip-card-front">
                            <img src="{{ asset('images/maine.png') }}" alt="Jhermaine Parrucho">
                        </div>
                        <div class="flip-card-back">
                            <p class="text-sm text-center">
                            Jhermaine Parrucho specializes in machine learning and is responsible for developing and refining the predictive algorithms used in our system. His work is crucial to the accuracy and reliability of the predictive models.
                            </p>
                        </div>
                    </div>
                    <p class="name__h1 text-xl text-center font-bold mt-8">Jhermaine Parrucho</p>
                </div>
            </div>
        </div>
    <div class="mx-36 border-t border-gray-600 mt-36"></div>
    <div class="text-center"> 
        <a href="https://github.com/parruchoPLP/PredictingLicensureExamination" title="Our Github Repository">
            <i class="fab fa-github text-3xl dark:text-slate-400 hover:text-emerald-400 dark:hover:text-emerald-400 mt-16 self-center"></i>
        </a>
    </div>
</section>

<script>
    document.getElementById('learnMoreLink').addEventListener('click', function(event) {
        event.preventDefault();
        document.querySelector('#aboutUs').scrollIntoView({
            behavior: 'smooth'
        });
    });

    const options = {
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
                color: "#34d399",
            },
            {
                name: "PLP Passing Rate",
                data: ['58.33', '41.67', '53.85', '61.11', '33.33', '66.67', '16.67', '20.00', '16.67'],
                color: "#22d3ee",
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
        const chart = new ApexCharts(document.getElementById("labels-chart"), options);
        chart.render();
    }
</script>
@endsection