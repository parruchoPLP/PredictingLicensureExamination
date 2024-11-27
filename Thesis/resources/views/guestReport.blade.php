@extends('layouts.app')

@section('title', 'Results')

@section('content')

<button id="darkmode-toggle" class="fixed bottom-4 right-4 z-20 py-3 px-4 text-2xl text-slate-600 bg-white dark:bg-slate-900 dark:text-emerald-300 shadow-lg rounded-xl hover:bg-slate-200 hover:dark:bg-slate-600 transition-transform transform hover:scale-105">
    <i id="darkmode-icon" class="fa fa-moon"></i>
</button>

<section class="bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 flex justify-center items-center min-h-screen font-arial">
    <div id="result-section" class="text-justify bg-white dark:bg-slate-700 rounded-xl shadow-lg flex flex-col max-w-4xl w-full relative">
        <div class="flex justify-between items-center border-b border-slate-200 dark:border-slate-800 px-8 py-6 rounded-t-xl">
            <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400">Predicted Electronics Engineers Licensure Exam Performance</p>
        </div>

        @php
            $expectedStatus = 'Less Likely to Pass'; 
            $reason = 'Highly Likely to Fail in Category 1 of the exam.';
            $recommendedIntervention = 'Focus on improving in the topics and courses under the aforementioned areas.';
            $fontColor = ($expectedStatus === 'Less Likely to Pass') ? 'text-red-500' : 'text-emerald-500';
        @endphp
        
        <div class="p-8">
            <p class="text-md font-medium">Based on your input, your predicted performance in the Electronics Engineers Licensure Exam is:</p>
            <p class="font-bold text-2xl my-3 {{ $fontColor }}">{{ $expectedStatus }}</p>
            
            <div id="intervention">
                @if ($expectedStatus === 'Less Likely to Pass')
                    <p class="font-semibold">Reason: <span class="font-normal">{{ $reason }}</span></p>
                    <p class="font-semibold">Recommended Intervention: <span class="font-normal">{{ $recommendedIntervention }}</span></p>
                @else
                    <p class="font-semibold">Potential Areas of Concern: <span class="font-normal">{{ $reason }}</span></p>
                    <p class="font-semibold">Suggested Actions: <span class="font-normal">{{ $recommendedIntervention }}</span></p>
                @endif
            </div>

            <p class="text-sm font-medium mt-3"><i>This prediction is based on your academic performance and is for guidance purposes only.</i></p>

            <p class="text-sm font-medium mt-8">
                View the latest 
                <a href="https://www.inhenyero.com/2020/04/ece-board-exam-coverage.html#google_vignette" target="_blank" class="underline hover:text-emerald-700">
                    Electronics Engineers Licensure Exam coverage.
                </a>
            </p>
            
            <div class="bottom-4 left-4 right-4 flex justify-between mt-8">
                <button id="home-btn" 
                    class="py-3 px-8 text-sm font-medium rounded-lg bg-transparent hover:bg-emerald-300 border border-emerald-300 dark:hover:bg-emerald-600 focus:ring-2 focus:outline-none focus:ring-emerald-300 dark:focus:ring-emerald-800">
                    <i class="fa fa-home"></i>
                </button>
                <button id="email-btn" 
                    class="py-3 px-8 text-sm font-medium rounded-lg bg-emerald-200 hover:bg-emerald-300 dark:bg-emerald-400 dark:hover:bg-emerald-600 focus:ring-2 focus:outline-none focus:ring-emerald-300 dark:focus:ring-emerald-800">
                    Send Result to Email
                </button>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('home-btn').addEventListener('click', () => {
        window.location.href = '/about'; 
    });

    document.getElementById('email-btn').addEventListener('click', () => {
        const userEmail = prompt("Enter your email address to receive the result:");
        if (userEmail) {
            alert(`Result has been sent to ${userEmail}.`);
        }
    });
</script>

@endsection
