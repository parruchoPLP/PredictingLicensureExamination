@if (session('success_title') && session('success_info'))
    <x-success_alert 
        :successTitle="session('success_title')" 
        :successInfo="session('success_info')" />
@endif

@if ($errors->any())
    <x-error_alert />
@endif

<button id="navbar-toggle" class="fixed top-4 left-4 z-50 py-3 px-4 text-2xl text-slate-600 bg-white dark:bg-slate-900 dark:text-slate-200 shadow-lg rounded-xl hover:bg-slate-200 hover:dark:bg-slate-600 transition-transform transform hover:scale-105" type="button" data-drawer-target="navbar" data-drawer-show="navbar" aria-controls="navbar">
    <i class="fa fa-bars"></i>
</button>

<button id="darkmode-toggle" class="fixed bottom-4 right-4 z-20 py-3 px-4 text-2xl text-slate-600 bg-white dark:bg-slate-900 dark:text-slate-200 shadow-lg rounded-xl hover:bg-slate-200 hover:dark:bg-slate-600 transition-transform transform hover:scale-105">
    <i id="darkmode-icon" class="fa fa-moon"></i>
</button>

<nav id="navbar" class="fixed top-0 left-0 h-full shadow-xl w-auto bg-white dark:bg-slate-900 flex flex-col items-center font-arial text-lg z-50 transform -translate-x-full transition-transform duration-300 ease-in-out" tabindex="-1" aria-labelledby="navbar-label">
    <h5 id="navbar-label" class="sr-only">Navigation</h5>
    <button id="navbar-close" class="absolute top-4 right-4 text-xl dark:text-slate-200 text-slate-900" type="button" data-drawer-hide="navbar" aria-controls="navbar">
        <i class="fa fa-times"></i>
    </button>
    <ul class="pt-24 px-4">
        <li>
            <a href="/dashboard" class="block py-6 px-14 rounded-lg text-slate-800 dark:text-slate-200 hover:text-emerald-500 dark:hover:text-emerald-300 hover:font-bold {{ request()->is('dashboard') ? 'bg-slate-300 font-bold dark:bg-gray-700' : '' }}">
                <i class="fa fa-tachometer-alt mr-6"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="/filemanagement" class="block py-6 px-14 rounded-lg text-slate-800 dark:text-slate-200 hover:text-emerald-500 dark:hover:text-emerald-300 hover:font-bold {{ request()->is('filemanagement', 'report') ? 'bg-slate-300 font-bold dark:bg-gray-700' : '' }}">
                <i class="fa fa-folder mr-6"></i>
                Files
            </a>
        </li>
        <li>
            <a href="/acctmanagement" class="block py-6 px-14 rounded-lg text-slate-800 dark:text-slate-200 hover:text-emerald-500 dark:hover:text-emerald-300 hover:font-bold {{ request()->is('acctmanagement') ? 'bg-slate-300 font-bold dark:bg-gray-700' : '' }}">
                <i class="fa fa-user mr-6"></i>
                User
            </a>
        </li>
    </ul>
    <form action="/logout" method="POST" class="mt-auto w-full">
        @csrf
        <button type="submit" class="block py-6 w-full text-slate-800 dark:text-slate-200 hover:text-emerald-500 dark:hover:text-emerald-300 hover:font-bold border-t border-slate-300 dark:border-gray-700">
            <i class="fa fa-sign-out-alt mr-6"></i>
            Logout
        </button>
    </form>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const drawers = document.querySelectorAll('[data-drawer-target]');
        drawers.forEach(drawer => {
            const targetId = drawer.getAttribute('data-drawer-target');
            const target = document.getElementById(targetId);
            if (!target) return;

            const showEvent = drawer.getAttribute('data-drawer-show');
            if (showEvent) {
                drawer.addEventListener('click', () => {
                    target.classList.remove('-translate-x-full');
                });
            }

            const hideEvent = drawer.getAttribute('data-drawer-hide');
            if (hideEvent) {
                const hideButton = target.querySelector(`[data-drawer-hide="${hideEvent}"]`);
                if (hideButton) {
                    hideButton.addEventListener('click', () => {
                        target.classList.add('-translate-x-full');
                    });
                }
            }
        });
    });
</script>
