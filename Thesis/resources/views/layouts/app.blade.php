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
@if(!Request::is('login') && !Request::is('about') && !Request::is('guestpage') && !Request::is('guestReport'))
<body class="bg-gray-100 overflow-x-hidden {{ session('darkmode') ? 'dark' : '' }}">
    <header>
        <x-navigationbar />
        @if(!Request::is('acctmanagement'))
        <div class="flex items-center fixed top-14 right-8 z-9 space-x-8 font-arial dark:text-slate-100 after-nav-div"> 
            <div class="flex items-center space-x-8 fixed left-36"> 
                @if(Request::is('dashboard'))
                    <h1 class="text-3xl font-bold"> Dashboard </h1>
                @endif
                <div class="hidden sm:block">
                    @include('components.clock')
                </div>
            </div>
            <div class="flex space-x-8 items-center">
                <button id="darkmode-toggle" class="text-lg text-slate-600 border border-slate-300 hover:bg-emerald-200 dark:hover:bg-emerald-800 rounded-full px-4 py-2 dark:text-slate-100 transition-transform transform hover:scale-105">
                    <i id="darkmode-icon" class="fa fa-moon"></i>
                </button>
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
@if(Request::is('guestpage'))
<body class="bg-gray-100 overflow-x-hidden {{ session('darkmode') ? 'dark' : '' }}">
    <main>
        @yield('content')
        @stack('scripts')
    </main>
</body>
@endif
@if(Request::is('guestReport'))
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