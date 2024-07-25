@extends('layouts.app')

@section('title', 'Account Management')

@section('content')
<section id="acctmanagement" class="bg-slate-100 min-h-screen px-32 py-24 font-arial">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <p class="font-bold text-2xl text-slate-800"> <i class="fas fa-user mr-6"></i> Your account </p>
        <form action="{{ route('profile.update') }}" method="POST" class="mt-8 space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-slate-600 font-semibold">Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border border-slate-300 rounded-md p-2" value="{{ old('name', auth()->user()->name) }}" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="username" class="block text-slate-600 font-semibold">Username</label>
                <input type="text" name="username" id="username" class="mt-1 block w-full border border-slate-300 rounded-md p-2" value="{{ old('username', auth()->user()->username) }}" required>
                @error('username')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="current_password" class="block text-slate-600 font-semibold">Current Password</label>
                <input type="password" id="current_password" class="mt-1 block w-full border border-slate-300 rounded-md p-2" value="{{ old('current_password', '********') }}" disabled>
            </div>
            <div id="change-password-section" class="hidden">
                <div>
                    <label for="password" class="block text-slate-600 font-semibold">New Password</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border border-slate-300 rounded-md p-2">
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-slate-600 font-semibold">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border border-slate-300 rounded-md p-2">
                    @error('password_confirmation')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex justify-end">
                <button type="button" id="change-password-button" class="underline text-slate-600 py-2 px-4 hover:text-emerald-600">
                    Change Password
                </button>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="mt-8 py-4 px-6 bg-emerald-200 rounded-lg font-bold hover:bg-emerald-600 hover:text-slate-200 ">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const changePasswordButton = document.getElementById('change-password-button');
        const changePasswordSection = document.getElementById('change-password-section');
        const currentPasswordInput = document.getElementById('current_password');

        changePasswordButton.addEventListener('click', function () {
            changePasswordSection.classList.toggle('hidden');
            if (!changePasswordSection.classList.contains('hidden')) {
                currentPasswordInput.type = 'text';  
                currentPasswordInput.value = '';
                currentPasswordInput.disabled = false; 
            } else {
                currentPasswordInput.type = 'password'; 
                currentPasswordInput.value = '********'; 
                currentPasswordInput.disabled = true; 
            }
        });
    });
</script>
@endsection
