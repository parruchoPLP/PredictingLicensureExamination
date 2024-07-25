@if (session('success_title') && session('success_info'))
    <x-success_alert 
        :successTitle="session('success_title')" 
        :successInfo="session('success_info')" />
@endif

@if ($errors->any())
    <x-error_alert />
@endif
<nav class="fixed top-0 left-0 h-full w-auto bg-slate-200 flex flex-col items-center font-arial text-lg z-50">
    <ul class="pt-14">
        <li>
            <a href="/dashboard" class="block py-8 px-16 text-slate-800 hover:bg-emerald-200 hover:font-bold {{ request()->is('dashboard') ? 'text-emerald-600 font-bold' : '' }}">
                <i class="fa fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="/filemanagement" class="block py-8 px-16 text-slate-800 hover:bg-emerald-200 hover:font-bold {{ request()->is('filemanagement') ? 'text-emerald-600 font-bold' : '' }}">
                <i class="fa fa-folder mr-3"></i>
                Files
            </a>
        </li>
        <li>
            <a href="/analytics" class="block py-8 px-16 text-slate-800 hover:bg-emerald-200 hover:font-bold {{ request()->is('analytics') ? 'text-emerald-600 font-bold' : '' }}">
                <i class="fa fa-chart-line mr-3"></i>
                Analytics
            </a>
        </li>
    </ul>
    <form action="/logout" method="POST" class="mt-auto w-full">
        @csrf
        <button type="submit" class="block py-8 w-full text-slate-800 hover:bg-emerald-200 hover:font-bold">
            <i class="fa fa-sign-out-alt mr-3"></i>
            Logout
        </button>
    </form>
</nav>