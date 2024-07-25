<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="icon" href="{{ asset('images/css_logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="" defer></script>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @stack('scripts')
    @yield('styles')
</head>
@if(!Request::is('login'))
<body class="bg-gray-100 overflow-x-hidden">
    <header>
        <x-navigationbar />
    </header>

    <main>
        @yield('content')
        @stack('scripts')
    </main>
</body>
@endif
@if(Request::is('login'))
<body class="bg-gray-100 overflow-x-hidden">
    <main>
        @yield('content')
        @stack('scripts')
    </main>
</body>
@endif
</html>