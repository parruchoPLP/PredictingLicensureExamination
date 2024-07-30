@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section id="dashboard" class="bg-slate-100 text-slate-900 dark:bg-slate-800 dark:text-slate-200 min-h-screen pr-9 pl-36 py-24 space-y-12 font-arial">
    <h1 class="text-5xl font-bold"> Welcome, Dean! </h1>
    <div class="border-t border-gray-600"></div>
    <div class="grid grid-cols-1 md:grid-cols-7 gap-4">
        <div class="bg-white dark:bg-slate-700 p-10 rounded-xl shadow-md md:col-span-2">
            <div class="flex items-center justify-between"> 
                <h2 class="text-2xl font-bold">Overall Passing Rate</h2>
                <i class="fa fa-ellipsis ml-auto hover:bg-emerald-100 dark:hover:bg-emerald-800 rounded-full p-2"></i>
            </div>
            <div class="flex items-center justify-center h-full">
                <canvas id="overallPassingRateChart" class="max-w-[160px] max-h-[160px]"></canvas>
            </div>
        </div>
        <div class="bg-white p-10 dark:bg-slate-700 rounded-xl shadow-md flex flex-col md:col-span-2 overflow-auto">
            <h2 class="text-2xl font-bold">Top 3 Licensure Outcome Predictors</h2>
            <ul id="topPredictorsList" class="text-2xl mt-10 space-y-2">
            </ul>
        </div>
        <div class="bg-white dark:bg-slate-700 p-8 rounded-xl shadow-md max-h-[400px] relative overflow-auto md:col-span-3">
            <div class="flex items-center justify-between mb-8"> 
                <h2 class="text-2xl font-bold">Feature Importance</h2>
                <i class="fa fa-ellipsis ml-auto hover:bg-emerald-100 dark:hover:bg-emerald-800 rounded-full p-2"></i>
            </div>
            <canvas id="featureImportanceChart" style="max-width: 100%;"></canvas>
        </div>
    </div>
    <h1 class="text-3xl font-bold"> Model metrics: </h1>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-700 p-10 rounded-xl shadow-md overflow-auto">
            <div class="flex items-center justify-between mb-10"> 
                <h2 class="text-2xl font-bold">Accuracy</h2>
                <i class="fa fa-ellipsis ml-auto hover:bg-emerald-100 dark:hover:bg-emerald-800 rounded-full p-2"></i>
            </div>
            <div class="flex items-center justify-center">
                <canvas id="averagePredictionAccuracyChart" class="max-w-[180px] max-h-[100px]"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-700 p-10 rounded-xl shadow-md overflow-auto">
            <div class="flex items-center justify-between mb-10"> 
                <h2 class="text-2xl font-bold">Precision</h2>
                <i class="fa fa-ellipsis ml-auto hover:bg-emerald-100 dark:hover:bg-emerald-800 rounded-full p-2"></i>
            </div>
            <div class="flex items-center justify-center">
                <canvas id="precisionChart" class="max-w-[180px] max-h-[100px]"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-700 p-10 rounded-xl shadow-md overflow-auto">
            <div class="flex items-center justify-between mb-10"> 
                <h2 class="text-2xl font-bold">Recall</h2>
                <i class="fa fa-ellipsis ml-auto hover:bg-emerald-100 dark:hover:bg-emerald-800 rounded-full p-2"></i>
            </div>
            <div class="flex items-center justify-center">
                <canvas id="recallChart" class="max-w-[180px] max-h-[100px]"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-700 p-10 rounded-xl shadow-md overflow-auto">
            <div class="flex items-center justify-between mb-10"> 
                <h2 class="text-2xl font-bold">F1 Score</h2>
                <i class="fa fa-ellipsis ml-auto hover:bg-emerald-100 dark:hover:bg-emerald-800 rounded-full p-2"></i>
            </div>
            <div class="flex items-center justify-center">
                <canvas id="f1ScoreChart" class="max-w-[180px] max-h-[100px]"></canvas>
            </div>
        </div>
    </div>
</section>
@endsection