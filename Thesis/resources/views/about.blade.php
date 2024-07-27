@extends('layouts.app')

@section('title', 'Predicting EE Licensure Exam Performance')

@section('styles')
<style>
    .flip-card-container {
        display: flex;
        gap: 16px; 
        justify-content: center;
        flex-wrap: wrap; 
    }
    .flip-card {
        width: 250px;
        height: 400px;
        perspective: 1000px;
        margin: 0;
    }
    .flip-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.5s;
        transform-style: preserve-3d;
    }
    .flip-card:hover .flip-card-inner {
        transform: rotateY(180deg);
    }
    .flip-card-front,
    .flip-card-back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
    }
    .flip-card-back {
        transform: rotateY(180deg);
        padding: 1rem;
        box-sizing: border-box;
    }
    .flip-card-front img,
    .flip-card-back img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .flipcard__name {
        margin-top: 1rem;
        text-align: center;
    }
    .name__h1 {
        font-size: 1.25rem;
        font-weight: bold;
        color: white;
    }
    .name__p {
        font-size: 1rem;
    }
    .section-spacing {
        margin-top: 4rem; 
    }
</style>
@endsection

@section('content')
<section id="titlePage" class="relative bg-cover bg-center bg-no-repeat font-arial" style="background-image: url('{{ asset('images/bsece.jpg') }}');">
    <div class="absolute inset-0 bg-gradient-to-t from-slate-800 to-transparent"></div>
    <div class="relative px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-48">
        <h1 class="my-8 text-4xl text-white font-extrabold md:text-5xl lg:text-6xl" style="text-shadow: #0f172a 1px 0 10px;">Predicting Electronics Engineers Licensure Exam Performance</h1>
        <p class="mb-14 text-lg text-gray-200 lg:text-xl sm:px-16 lg:px-48" style="text-shadow: #0f172a 1px 0 10px;">Empowering Electronics Engineering Students: Early Insights, Targeted Support, Enhanced Success.</p>
        <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
            <a href="/login" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center dark:text-black rounded-lg bg-emerald-300 text-slate-900 transition-transform transform hover:scale-105 cursor-pointer">
                Log in
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
            <a href="#aboutUs" id="learnMoreLink" class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-emerald-200 rounded-lg border border-emerald-200 hover:bg-emerald-300 transition-transform transform hover:scale-105 cursor-pointer">
                Learn more
            </a>  
        </div>
    </div>
</section>
<section id="aboutUs" class="min-h-screen bg-slate-800 pb-36 font-arial">  
    <div class="flex flex-col md:flex-row items-center p-36"> 
        <div class="w-full max-w-3xl md:max-w-4xl bg-slate-700 p-5 rounded-lg shadow-lg dark:bg-slate-700 transition-transform transform hover:scale-105 hover:shadow-2xl cursor-pointer">
            <div class="flex justify-between p-4 md:p-6 pb-0 md:pb-0">
                <div>
                    <h5 class="leading-none text-3xl font-bold text-white pb-2">PLP Electronics Engineers Licensure Exam Performance Chart</h5>
                </div>
            </div>
            <div id="labels-chart" class="px-2.5"></div>
        </div>
        <div class="md:ml-10 max-w-2xl text-white text-justify">
            <p class="text-5xl font-bold mb-6">Background</p>
            <p class="text-lg">The College of Engineering (CoENG) has generally outperformed the national average in the Electronics Engineers Licensure Examination. From 2018 to 2019, CoENG’s results were consistently better than the national rates, showing strong performance throughout this period. However, there was a dip in early 2019, though CoENG managed to exceed the national average later that year.<br><br>The situation changed significantly with the pandemic, which caused the exams to be canceled in 2020 and 2021. When the exams resumed, CoENG struggled to match its past performance. From 2022 onward, CoENG’s results fell below the national average, highlighting the impact of the pandemic on its performance. Despite some recovery attempts, CoENG’s passing rates remained lower than the national rates in the following years.</p>
        </div>
    </div>
    <div class="mx-36 border-t border-gray-600 mb-24"></div>
    <div class="px-36 text-justify text-white"> 
        <p class="text-5xl font-bold mb-10">Goals</p>
        <p class="text-lg">This system is designed to help the College of Engineering (CoENG) consistently outperform the national average in the Electronics Engineers Licensure Examination. By using a predictive model that analyzes academic performance, demographics, and other key factors, the system seeks to identify promising candidates early on. This will enable targeted interventions to enhance their chances of success and support students who face greater challenges.<br><br>Leveraging advanced machine learning techniques, specifically the Random Forest algorithm, the system provides actionable insights. In doing so, it aims to contribute to PLP’s goal of maintaining high performance and supporting the overall development of its Electronics Engineering students.</p>
    </div>
    <div class="mx-36 border-t border-gray-600 mt-24"></div>
        <div class="section-spacing">
            <div class="px-36 text-justify text-white">
                <h1 class="text-5xl font-bold mb-10 mt-24">Our Team</h1>
                <p class="text-lg text-center text-justify">
                Our team is dedicated to the development of a predictive system designed to enhance the performance of Electronics Engineering students at PLP in the Electronics Engineers Licensure Examination. Our objective is to ensure that the College of Engineering (CoENG) consistently surpasses the national average by leveraging advanced data analysis techniques.
                </p>
            </div>

            <div class="flip-card-container mt-10">
                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <img src="{{ asset('images/lovely.png') }}" alt="Lovely Ann Baylon">
                        </div>
                        <div class="flip-card-back">
                            <p class="text-sm text-center">
                            Lovely Ann Baylon focuses on the design aspects of our system. Her role involves creating a user-friendly interface that facilitates easy interaction with the system and ensures that the visual presentation of data is clear and effective.
                            </p>
                        </div>
                    </div>
                    <div class="flipcard__name">
                        <p class="name__h1">Lovely Ann Baylon</p>
                    </div>
                </div>

                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <img src="{{ asset('images/ede.png') }}" alt="Edelyn Carable">
                        </div>
                        <div class="flip-card-back">
                            <p class="text-sm text-center">
                            Edelyn Carable also contributes to the design and usability of the system. Her expertise helps ensure that the system is both functional and aesthetically pleasing, enhancing the user experience for both students and administrators.
                            </p>
                        </div>
                    </div>
                    <div class="flipcard__name">
                        <p class="name__h1">Edelyn Carable</p>
                    </div>
                </div>

                <div class="flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <img src="{{ asset('images/maine.png') }}" alt="Jhermaine Parrucho">
                        </div>
                        <div class="flip-card-back">
                            <p class="text-sm text-center">
                            Jhermaine Parrucho specializes in machine learning and is responsible for developing and refining the predictive algorithms used in our system. His work is crucial to the accuracy and reliability of the predictive models.
                            </p>
                        </div>
                    </div>
                    <div class="flipcard__name">
                        <p class="name__h1">Jhermaine Parrucho</p>
                    </div>
                </div>
            </div>
        </div>
    <div class="mx-36 border-t border-gray-600 mt-24"></div>
    <div class="text-center"> 
        <a href="https://github.com/parruchoPLP/PredictingLicensureExamination" title="Our Github Repository">
            <i class="fab fa-github text-3xl text-slate-400 hover:text-emerald-400 mt-16 self-center"></i>
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
                color: "#34d399",
            },
            {
                name: "PLP Passing Rate",
                data: ['53.85', '61.11', '33.33', '66.67', '16.67', '20.00', '16.67'],
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
        const chart = new ApexCharts(document.getElementById("labels-chart"), options);
        chart.render();
    }
</script>
@endsection