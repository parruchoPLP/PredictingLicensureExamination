@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section id="dashboard" class="bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-100 min-h-screen pr-9 pl-36 py-36 space-y-8 font-arial">
    <div class="grid grid-cols-1 lg:grid-cols-5 mid-lg:grid-cols-1 gap-4">
        <div class="bg-emerald-50 p-8 dark:bg-slate-700 rounded-xl shadow-md flex flex-col mid-lg:grid-cols-1 overflow-auto">
            <div class="flex justify-between"> 
                <h2 class="text-xl font-bold">Overall Passing Rate</h2>
                <i class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2"></i>
            </div>
            <div class="flex justify-center pt-8">
                <div class="max-w-[180px]" id="passingRate-chart"></div>
            </div>
        </div>  
        <div class="bg-white p-8 dark:bg-slate-700 rounded-xl shadow-md flex flex-col md:col-span-3 mid-lg:grid-cols-1 overflow-auto">
            <div class="flex justify-between"> 
                <h2 class="text-xl font-bold mb-10">Feature Importance</h2>
                <i class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2"></i>
            </div>
            <div id="feature-chart"></div>
        </div>  
        <div class="bg-white p-8 dark:bg-slate-700 rounded-xl shadow-md flex flex-col mid-lg:grid-cols-1 overflow-auto">
            <div class="flex justify-between"> 
                <h2 class="text-xl font-bold">Top 3 Licensure Outcome Predictors</h2>
                <i class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2"></i>
            </div>
            <ul id="topPredictorsList" class="list-decimal list-inside text-md mt-10 space-y-2">
            </ul>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-7 mid-lg:grid-cols-1 gap-4">
        <div class="bg-white p-8 dark:bg-slate-700 rounded-xl shadow-md flex flex-col md:col-span-5 overflow-auto">
            <div class="flex justify-between"> 
                <h2 class="text-xl font-bold">PLP CoENG Electronics Engineers Licensure Exam Performance</h2>
                <i class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2"></i>
            </div>
            <div id="labels-chart" class="px-2.5"></div>
        </div>
        <div class="bg-emerald-50 p-8 dark:bg-slate-700 rounded-xl shadow-md flex flex-col md:col-span-2 overflow-auto">
            <div class="flex justify-between"> 
                <h2 class="text-xl font-bold">Performance Metrics</h2>
                <i class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2"></i>
            </div>    
            <div class="py-6" id="metrics-chart"></div>
        </div>
    </div>
</section>
@endsection
