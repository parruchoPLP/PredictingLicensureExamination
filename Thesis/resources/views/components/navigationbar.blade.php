@if (session('success_title') && session('success_info'))
    <x-success_alert 
        :successTitle="session('success_title')" 
        :successInfo="session('success_info')" />
@endif

@if ($errors->any())
    <x-error_alert />
@endif

<button id="darkmode-toggle" class="fixed bottom-4 right-4 z-20 py-3 px-4 text-2xl text-slate-600 bg-white dark:bg-slate-900 dark:text-slate-100 shadow-lg rounded-xl hover:bg-slate-200 hover:dark:bg-slate-600 transition-transform transform hover:scale-105">
    <i id="darkmode-icon" class="fa fa-moon"></i>
</button>

<nav id="navbar" class="fixed top-4 left-4 bottom-4 w-auto hover:w-64 rounded-xl shadow-lg bg-white dark:bg-slate-700 flex flex-col items-center font-arial text-md z-50 transition-all duration-300 ease-in-out" tabindex="-1" aria-labelledby="navbar-label">
    <ul class="mt-8 p-4 w-full space-y-2 text-slate-800 dark:text-slate-200">
        <li class="group">
            <a href="/dashboard" class="block p-4 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-800 hover:font-bold {{ request()->is('dashboard') ? 'text-emerald-500 font-bold' : '' }}">
                <i class="fa fa-tachometer-alt"></i>
                <span class="hidden group-hover:inline ml-4">Dashboard</span>
            </a>
        </li>
        <li class="group">
            <a href="/filemanagement" class="block p-4 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-800 hover:font-bold {{ request()->is('filemanagement', 'report') ? 'text-emerald-500 font-bold' : '' }}">
                <i class="fa fa-folder"></i>
                <span class="hidden group-hover:inline ml-4">Files</span>
            </a>
        </li>
        <li class="group">
            <a href="/acctmanagement" class="block p-4 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-800 hover:font-bold {{ request()->is('acctmanagement') ? 'text-emerald-500 font-bold' : '' }}">
                <i class="fa fa-user"></i>
                <span class="hidden group-hover:inline ml-4">User</span>
            </a>
        </li>
        <li class="group">
            <a href="/systemfiles" class="block p-4 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-800 hover:font-bold {{ request()->is('systemfiles') ? 'text-emerald-500 font-bold' : '' }}">
                <i class="fa fa-cog"></i>
                <span class="hidden group-hover:inline ml-4">System Files</span>
            </a>
        </li>
        <li class="group">
            <a href="/archivedfiles" class="block p-4 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-800 hover:font-bold {{ request()->is('archivedfiles') ? 'text-emerald-500 font-bold' : '' }}">
                <i class="fas fa-archive"></i>
                <span class="hidden group-hover:inline ml-4">Archived Files</span>
            </a>
        </li>
    </ul>
    <form action="/logout" method="POST" class="mt-auto w-full p-4 border-t border-slate-300 dark:border-gray-800">
        @csrf
        <button type="submit" class="block p-4 rounded-lg w-full text-left text-slate-800 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-800 hover:font-bold">
            <i class="fa fa-sign-out-alt"></i>
            <span class="hidden group-hover:inline ml-4">Logout</span>
        </button>
    </form>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navbar = document.getElementById('navbar');
        navbar.addEventListener('mouseover', () => {
            navbar.classList.add('w-64');
            document.querySelectorAll('#navbar span').forEach(span => {
                span.classList.remove('hidden');
            });
        });
        navbar.addEventListener('mouseout', () => {
            navbar.classList.remove('w-64');
            document.querySelectorAll('#navbar span').forEach(span => {
                span.classList.add('hidden');
            });
        });
    });
</script>
