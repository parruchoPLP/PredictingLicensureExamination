@extends('layouts.app')

@section('title', 'Login')

@section('content')
@if (session('success_title') && session('success_info'))
    <x-success_alert 
        :successTitle="session('success_title')" 
        :successInfo="session('success_info')" />
@endif

@if ($errors->any())
    <x-error_alert />
@endif
<button id="darkmode-toggle" class="fixed bottom-4 right-4 z-20 py-3 px-4 text-2xl text-slate-600 bg-white dark:bg-slate-900 dark:text-emerald-300 shadow-lg rounded-xl hover:bg-slate-200 hover:dark:bg-slate-600 transition-transform transform hover:scale-105">
    <i id="darkmode-icon" class="fa fa-moon"></i>
</button>

<div id="informational-banner" tabindex="-1" class="fixed top-0 start-0 z-20 flex flex-col font-arial shadow-sm justify-between w-full p-8 border-b border-gray-200 md:flex-row bg-slate-200 dark:bg-gray-700 dark:border-gray-600">
    <div class="mb-4 md:mb-0 md:me-4">
        <h2 class="mb-1 text-xl font-semibold text-gray-900 dark:text-white">Predicting Electronics Engineers Licensure Exam Performance</h2>
        <p class="flex items-center font-normal text-gray-500 dark:text-gray-400">Empowering electronics engineering students with early insights, targeted support, and enhanced success.</p>
    </div>
    <div class="flex items-center flex-shrink-0">
        <a href="/about" class="inline-flex items-center justify-center px-3 py-3 me-4 font-medium text-white bg-emerald-500 rounded-lg hover:bg-emerald-800"><svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
            <path d="M9 1.334C7.06.594 1.646-.84.293.653a1.158 1.158 0 0 0-.293.77v13.973c0 .193.046.383.134.55.088.167.214.306.366.403a.932.932 0 0 0 .5.147c.176 0 .348-.05.5-.147 1.059-.32 6.265.851 7.5 1.65V1.334ZM19.707.653C18.353-.84 12.94.593 11 1.333V18c1.234-.799 6.436-1.968 7.5-1.65a.931.931 0 0 0 .5.147.931.931 0 0 0 .5-.148c.152-.096.279-.235.366-.403.088-.167.134-.357.134-.55V1.423a1.158 1.158 0 0 0-.293-.77Z"/>
        </svg> Learn more</a>
        <button data-dismiss-target="#informational-banner" type="button" class="flex-shrink-0 inline-flex justify-center w-7 h-7 items-center text-gray-400 hover:bg-emerald-200 hover:text-gray-900 rounded-lg text-sm p-1.5 dark:text-slate-200 dark:hover:bg-emerald-700">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close banner</span>
        </button>
    </div>
</div>

<section class="bg-slate-100 dark:bg-slate-800 flex justify-center items-center min-h-screen font-arial">
    <div class="bg-white dark:bg-slate-700 p-12 rounded-xl shadow-lg flex flex-col items-center">
        <p class="font-bold text-4xl text-emerald-600 text-center mb-3 dark:text-emerald-400">Welcome!</p>
        <p class="text-md text-emerald-600 text-center mb-16 dark:text-emerald-300">Log in to your account.</p>
        <form action="/authenticate" method="POST">
            @csrf
            <div class="relative mb-3">
                <input type="text" id="username" name="username" class="peer bg-slate-100 dark:bg-gray-700 dark:border-emerald-400 rounded-full p-4 text-slate-800 dark:text-slate-200 text-md min-w-[350px] focus:outline-none focus:ring-2 focus:ring-emerald-600" placeholder=" " required autofocus>
                <label for="username" class="absolute text-md left-4 top-4 text-slate-600 dark:text-slate-400 duration-300 transform -translate-y-4 scale-75 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">Username</label>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                    <i class="fas fa-user text-slate-800 dark:text-slate-200"></i>
                </div>
            </div>
            <div class="relative mb-3">
                <input type="password" id="password" name="password" class="peer bg-slate-100 dark:bg-gray-700 dark:border-emerald-400 rounded-full p-4 text-slate-800 dark:text-slate-200 text-md min-w-[350px] focus:outline-none focus:ring-2 focus:ring-emerald-600" placeholder=" " required>
                <label for="password" class="absolute text-md left-4 top-4 text-slate-600 dark:text-slate-400 duration-300 transform -translate-y-4 scale-75 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">Password</label>
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center h-full focus:outline-none">
                    <i class="fas fa-eye text-slate-800 dark:text-slate-200 hover:text-emerald-600"></i>
                </button>
            </div>
            <div>
                <button type="submit" name="submit" class="bg-emerald-400 text-slate-900 dark:text-black font-bold p-4 px-6 text-md rounded-full mt-5 min-w-[350px] hover:bg-emerald-600 dark:hover:bg-emerald-600 dark:hover:text-slate-200 hover:text-slate-200">Log in</button>
            </div>
        </form>
        <a href="/guestpage" class="text-md text-emerald-600 mt-4 dark:text-emerald-300 hover:underline">Continue as guest.</a>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const icon = togglePassword.querySelector('i');
        
        togglePassword.addEventListener('click', function () {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>
@endsection
