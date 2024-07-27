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

<section class="bg-slate-100 dark:bg-slate-800 flex justify-center items-center min-h-screen font-arial">
    <div class="bg-white dark:bg-slate-700 p-12 rounded-xl shadow-lg">
        <p class="font-bold text-4xl text-emerald-600 text-center mb-3 dark:text-emerald-300">Welcome!</p>
        <p class="text-md text-emerald-600 text-center mb-16 dark:text-emerald-300">Log in to your account.</p>
        <form action="/authenticate" method="POST">
            @csrf
            <div class="relative mb-3">
                <input type="text" id="username" name="username" class="peer bg-slate-100 dark:bg-gray-700 rounded-full p-4 text-slate-800 dark:text-slate-200 text-md form-input min-w-[350px] focus:outline-none focus:ring-2 focus:ring-emerald-600" placeholder=" " required autofocus>
                <label for="username" class="absolute text-md left-4 top-4 text-slate-600 dark:text-slate-400 duration-300 transform -translate-y-4 scale-75 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">Username</label>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                    <i class="fas fa-user text-slate-800 dark:text-slate-200"></i>
                </div>
            </div>
            <div class="relative mb-3">
                <input type="password" id="password" name="password" class="peer bg-slate-100 dark:bg-gray-700 rounded-full p-4 text-slate-800 dark:text-slate-200 text-md min-w-[350px] focus:outline-none focus:ring-2 focus:ring-emerald-600" placeholder=" " required>
                <label for="password" class="absolute text-md left-4 top-4 text-slate-600 dark:text-slate-400 duration-300 transform -translate-y-4 scale-75 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">Password</label>
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center h-full focus:outline-none">
                    <i class="fas fa-eye text-slate-800 dark:text-slate-200 hover:text-emerald-600"></i>
                </button>
            </div>
            <div>
                <button type="submit" name="submit" class="bg-emerald-400 text-slate-900 dark:bg-emerald-500 dark:text-slate-200 font-bold p-4 px-6 text-md rounded-full mt-5 min-w-[350px] hover:bg-emerald-600 dark:hover:bg-emerald-400 hover:text-slate-200">Log in</button>
            </div>
        </form>
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
