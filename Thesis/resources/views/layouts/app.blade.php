<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="icon" href="{{ asset('images/css_logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="{{ asset('js/DarkMode.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @stack('scripts')
    @yield('styles')
</head>
@if(!Request::is('login') && !Request::is('about'))
<body class="bg-gray-100 overflow-x-hidden {{ session('darkmode') ? 'dark' : '' }}">
    <header>
        <x-navigationbar />
        @if(!Request::is('acctmanagement'))
        <div class="flex items-center fixed top-14 right-8 z-20 space-x-8 font-arial dark:text-slate-100 after-nav-div"> 
            <div class="flex items-center space-x-8 fixed left-36"> 
                @if(Request::is('dashboard'))
                    <h1 class="text-3xl font-bold"> Dashboard </h1>
                @endif
                <div class="hidden sm:block">
                    @include('components.clock')
                </div>
            </div>
            <div class="flex space-x-8">
                <form class="max-w-lg mx-auto hidden md:block">
                    <div class="flex">
                        <div class="relative w-full">
                            <input type="search" id="search-dropdown" class="block p-2 pl-4 w-full z-20 text-md font-medium text-slate-700 bg-transparent rounded-full border border-slate-300 focus:ring-emerald-500 focus:bg-emerald-50 focus:border-emerald-200 dark:text-slate-300 dark:focus:bg-transparent placeholder-slate-700 dark:placeholder-slate-300" placeholder="Search..." required/>
                            <button type="submit" class="absolute top-1 end-1 p-2 text-lg font-medium h-auto text-slate-700 bg-transparent rounded-full hover:bg-emerald-100 dark:text-slate-300 dark:hover:bg-emerald-800">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                                <span class="sr-only">Search</span>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="hidden lg:block">
                    <x-profile 
                        src="{{ asset('images/ece.png') }}" 
                        alt="Profile Picture" 
                        name="Dean" 
                        role="Administrator" 
                    />
                </div>
                @endif
            </div>
        </div>
    </header>

    <main>
        @yield('content')
        @stack('scripts')
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let lastScrollTop = 0;
            const scrollElement = document.querySelector('.after-nav-div'); // Select your div after the navbar

            window.addEventListener('scroll', function () {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > lastScrollTop) {
                    // Scrolling down
                    scrollElement.classList.add('hidden'); // Hide the div
                } else {
                    // Scrolling up
                    scrollElement.classList.remove('hidden'); // Show the div
                }
                lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // Ensure it doesn't go below 0
            });
        });
    </script>
</body>
@endif
@if(Request::is('login'))
<body class="bg-gray-100 overflow-x-hidden {{ session('darkmode') ? 'dark' : '' }}">
    <main>
        @yield('content')
        @stack('scripts')
    </main>
</body>
@endif
@if(Request::is('about'))
<body class="scroll-smooth">
    <main>
        @yield('content')
        @stack('scripts')
    </main>
</body>
@endif
</html>