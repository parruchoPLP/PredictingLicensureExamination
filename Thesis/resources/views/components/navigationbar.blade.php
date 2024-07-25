@if (session('success_title') && session('success_info'))
    <x-success_alert 
        :successTitle="session('success_title')" 
        :successInfo="session('success_info')" />
@endif

@if ($errors->any())
    <x-error_alert />
@endif
<button id="navbar-toggle" class="fixed top-4 left-4 z-50 p-3 text-3xl text-slate-900 rounded">
    <i class="fa fa-bars"></i>
</button>
<nav id="navbar" class="fixed top-0 left-0 h-full w-auto bg-slate-200 flex flex-col items-center font-arial text-xl z-50 transform -translate-x-full transition-transform duration-300 ease-in-out">
    <button id="navbar-close" class="absolute top-4 right-4 text-2xl text-slate-900">
        <i class="fa fa-times"></i>
    </button>
    <ul class="pt-24">
        <li>
            <a href="/dashboard" class="block py-8 px-16 text-slate-800 hover:bg-slate-300 hover:font-bold {{ request()->is('dashboard') ? 'text-emerald-600 font-bold' : '' }}">
                <i class="fa fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="/filemanagement" class="block py-8 px-16 text-slate-800 hover:bg-slate-300 hover:font-bold {{ request()->is('filemanagement') ? 'text-emerald-600 font-bold' : '' }}">
                <i class="fa fa-folder mr-3"></i>
                Files
            </a>
        </li>
        <li>
            <a href="/acctmanagement" class="block py-8 px-16 text-slate-800 hover:bg-slate-300 hover:font-bold {{ request()->is('acctmanagement') ? 'text-emerald-600 font-bold' : '' }}">
                <i class="fa fa-user mr-3"></i>
                User
            </a>
        </li>
    </ul>
    <form action="/logout" method="POST" class="mt-auto w-full">
        @csrf
        <button type="submit" class="block py-8 w-full text-slate-800 hover:bg-slate-300 hover:font-bold border-t border-slate-400">
            <i class="fa fa-sign-out-alt mr-3"></i>
            Logout
        </button>
    </form>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.getElementById('navbar-toggle');
        const closeButton = document.getElementById('navbar-close');
        const navbar = document.getElementById('navbar');

        toggleButton.addEventListener('click', function () {
            navbar.classList.toggle('-translate-x-full');
        });

        closeButton.addEventListener('click', function () {
            navbar.classList.add('-translate-x-full');
        });
    });
</script>