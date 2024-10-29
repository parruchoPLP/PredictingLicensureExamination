@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@vite(['resources/js/dashboard.js'])
<section id="dashboard" class="bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-100 min-h-screen pr-9 pl-36 py-36 space-y-8 font-arial">
    <!-- First grid for Passing Rate, Feature Importance, and Top Predictors -->
    <div class="grid grid-cols-1 lg:grid-cols-5 mid-lg:grid-cols-5 gap-4">
        <!-- Overall Passing Rate -->
        <div class="bg-emerald-50 p-8 dark:bg-slate-700 rounded-xl shadow-md flex flex-col overflow-auto">
            <div>
                <h2 class="text-xl font-bold">Overall Passing Rate
                    <button 
                        id="helpButton1"  
                        class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2 bg-transparent border-none"
                        aria-label="Help"
                    ></button> @include('components.popover', ['id' => 'popOverallPass'])
                </h2>
            </div>
            <div class="justify-center pt-8">
                <div class="max-w-[180px]" id="passingRate-chart"></div>
            </div>
        </div>

        <!-- Feature Importance -->
        <div class="bg-white p-8 dark:bg-slate-700 rounded-xl shadow-md flex flex-col mid-lg:col-span-3 overflow-auto">
            <div>
                <h2 class="text-xl font-bold mb-10">Feature Importance
                    <button 
                        id="helpButton2"  
                        class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2 bg-transparent border-none"
                        aria-label="Help"
                    ></button> @include('components.popover', ['id' => 'popFeature'])
                </h2>
            </div>
            <div id="feature-chart"></div>
        </div>  

        <!-- Top 5 Licensure Outcome Predictors -->
        <div class="bg-white p-8 dark:bg-slate-700 rounded-xl shadow-md flex flex-col overflow-auto">
            <div>
                <h2 class="text-xl font-bold">Top 5 Licensure Outcome Predictors
                    <button 
                        id="helpButton3"  
                        class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2 bg-transparent border-none"
                        aria-label="Help"
                    ></button> @include('components.popover', ['id' => 'popTopPredictors'])
                </h2>
            </div>
            <ul id="topPredictorsList" class="list-decimal list-inside text-md mt-10 space-y-2">
            </ul>
        </div>
    </div>

    <!-- Second grid for Average Grade per Course and Performance Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-7 mid-lg:grid-cols-7 gap-4">
        <!-- Average Grade per Course -->
        <div class="bg-white p-8 dark:bg-slate-700 rounded-xl shadow-md flex flex-col mid-lg:col-span-5 overflow-auto">
            <div>
                <h2 class="text-xl font-bold">Average Grade per Course
                    <button 
                        id="helpButton4"  
                        class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2 bg-transparent border-none"
                        aria-label="Help"
                    ></button> @include('components.popover', ['id' => 'popAveCourse'])
                </h2>
            </div>   
            <div id="overallaveperCourse-chart"></div>
        </div>

        <!-- Performance Metrics -->
        <div class="bg-emerald-50 p-8 dark:bg-slate-700 rounded-xl shadow-md flex flex-col mid-lg:col-span-2 overflow-auto">
            <div>
                <h2 class="text-xl font-bold">Performance Metrics
                    <button 
                        id="helpButton5"  
                        class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2 bg-transparent border-none"
                        aria-label="Help"
                    ></button> @include('components.popover', ['id' => 'popMetrics'])
                </h2>
            </div>    
            <div class="py-6" id="metrics-chart"></div>
        </div>
    </div>
</section>

<script>
    const featureImportance = @json($featureImportance);
    const modelMetrics = @json($modelMetrics);
    const averageCourse = @json($averageCourse);
    const topPredictors = @json($topPredictors);
    const passingRate = @json($passingRate);
</script>
@endsection 
