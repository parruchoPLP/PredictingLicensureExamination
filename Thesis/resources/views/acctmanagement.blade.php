@extends('layouts.app')

@section('title', 'Account Management')

@section('content')
<section id="acctmanagement" class="bg-slate-100 min-h-screen px-32 py-24 font-arial">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <p class="font-bold text-2xl text-slate-800"> <i class="fas fa-user mr-6"></i> Your account </p>
        <form action="{{ route('profile.update') }}" method="POST" class="mt-8 space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-slate-600 font-semibold">Name</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full border border-slate-300 rounded-md p-2 focus:ring-emerald-600" value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="username" class="block text-slate-600 font-semibold">Username</label>
                        <input type="text" name="username" id="username" class="mt-1 block w-full border border-slate-300 rounded-md p-2 focus:ring-emerald-600" value="{{ old('username', auth()->user()->username) }}" required>
                        @error('username')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <label for="current_password" class="block text-slate-600 font-semibold focus:ring-emerald-600">Current Password</label>
                        <input type="password" id="current_password" class="mt-1 block w-full border border-slate-300 rounded-md p-2" value="********" disabled>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="change-password-button" class="underline text-slate-600 py-2 px-4 hover:text-emerald-600">
                            Change Password
                        </button>
                    </div>
                    <div id="change-password-section" class="hidden">
                        <div class="relative">
                            <label for="password" class="block text-slate-600 font-semibold">New Password</label>
                            <input type="password" name="password" id="password" class="mt-1 block w-full border border-slate-300 rounded-md p-2 focus:ring-emerald-600">
                            <button type="button" class="absolute inset-y-3 right-0 pr-4 flex items-center h-full focus:outline-none toggle-password">
                                <i class="fas fa-eye text-slate-800 hover:text-emerald-600"></i>
                            </button>
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="relative mt-4">
                            <label for="password_confirmation" class="block text-slate-600 font-semibold">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border border-slate-300 rounded-md p-2 focus:ring-emerald-600">
                            <button type="button" class="absolute inset-y-3 right-0 pr-4 flex items-center h-full focus:outline-none toggle-password">
                                <i class="fas fa-eye text-slate-800 hover:text-emerald-600"></i>
                            </button>
                            @error('password_confirmation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <button type="submit" class="mt-8 py-4 px-6 bg-emerald-200 rounded-lg font-bold hover:bg-emerald-600 hover:text-slate-200">
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
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');

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

        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function () {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.querySelector('i').classList.remove('fa-eye');
                    this.querySelector('i').classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.querySelector('i').classList.remove('fa-eye-slash');
                    this.querySelector('i').classList.add('fa-eye');
                }
            });
        });
    });
</script>
@endsection
