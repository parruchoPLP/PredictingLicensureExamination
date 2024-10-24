@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section id="dashboard" class="bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-100 min-h-screen pr-9 pl-36 py-36 space-y-8 font-arial">
    <div class="grid grid-cols-1 lg:grid-cols-7 mid-lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-700 p-8 rounded-xl shadow-md md:col-span-2">
            <div class="flex items-center justify-between"> 
                <h2 class="text-xl font-bold">Overall Passing Rate</h2>
                <i class="fa fa-circle-info text-sm hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2"></i>
            </div>
            <div class="flex items-center justify-center h-full">
                <canvas id="overallPassingRateChart" class="max-w-[160px] max-h-[160px]"></canvas>
            </div>
        </div>
        <div class="bg-white p-8 dark:bg-slate-700 rounded-xl shadow-md flex flex-col md:col-span-2 overflow-auto">
            <div class="flex justify-between"> 
                <h2 class="text-xl font-bold">Top 3 Licensure Outcome Predictors</h2>
                <i class="fa fa-circle-info text-sm hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2"></i>
            </div>
            <ul id="topPredictorsList" class="list-decimal list-inside text-lg mt-10 space-y-2">
            </ul>
        </div>
        <div class="bg-white dark:bg-slate-700 p-8 rounded-xl shadow-md min-h-[400px] relative overflow-auto lg:col-span-3 mid-lg:col-span-4">
            <div class="flex items-center justify-between mb-8"> 
                <h2 class="text-xl font-bold">Feature Importance</h2>
                <i class="fa fa-circle-info text-sm hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2"></i>
            </div>
            <canvas id="featureImportanceChart" style="min-width: 100%;"></canvas>
        </div>
    </div>
    <h1 class="text-2xl font-bold"> Model metrics: </h1>
    <div class="grid grid-cols-1 lg:grid-cols-4 mid-lg:grid-cols-2 gap-4">
        <div class="bg-white dark:bg-slate-700 p-8 rounded-xl shadow-md overflow-auto">
            <div class="flex justify-between mb-10"> 
                <h2 class="text-xl font-bold">Accuracy</h2>
                <i class="fa fa-circle-info text-sm hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2"></i>
            </div>
            <div class="flex items-center justify-center">
                <canvas id="averagePredictionAccuracyChart" class="max-w-[180px] max-h-[100px]"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-700 p-8 rounded-xl shadow-md overflow-auto">
            <div class="flex items-center justify-between mb-10"> 
                <h2 class="text-xl font-bold">Precision</h2>
                <i class="fa fa-circle-info text-sm hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2"></i>
            </div>
            <div class="flex items-center justify-center">
                <canvas id="precisionChart" class="max-w-[180px] max-h-[100px]"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-700 p-8 rounded-xl shadow-md overflow-auto">
            <div class="flex items-center justify-between mb-10"> 
                <h2 class="text-xl font-bold">Recall</h2>
                <i class="fa fa-circle-info text-sm hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2"></i>
            </div>
            <div class="flex items-center justify-center">
                <canvas id="recallChart" class="max-w-[180px] max-h-[100px]"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-700 p-8 rounded-xl shadow-md overflow-auto">
            <div class="flex items-center justify-between mb-10"> 
                <h2 class="text-xl font-bold">F1 Score</h2>
                <i class="fa fa-circle-info text-sm hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2"></i>
            </div>
            <div class="flex items-center justify-center">
                <canvas id="f1ScoreChart" class="max-w-[180px] max-h-[100px]"></canvas>
            </div>
        </div>
    </div>
</section>
@endsection
