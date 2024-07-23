@vite('resources/css/app.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<nav class="fixed flex top-0 w-full p-3 px-32 z-20 bg-gradient-to-b from-slate-100 to-slate-100/10 font-arial overflow-x-auto">
    <div class="max-w-screen-xl mx-auto flex justify-between items-center font-bold">
        <ul class="flex p-3 text-2xl">
            <li>
                <a href="/dashboard" class="block mx-16 py-3 text-slate-800 hover:text-emerald-600 {{ request()->is('dashboard') ? 'border-b-2 border-slate-800' : '' }}">Dashboard</a>
            </li>
            <li>
                <a href="/filemanagement" class="block mx-16 py-3 text-slate-800 hover:text-emerald-600 {{ request()->is('filemanagement') ? 'border-b-2 border-slate-800' : '' }}">Files</a>
            </li>
            <li>
                <a href="/analytics" class="block mx-16 py-3 text-slate-800 hover:text-emerald-600 {{ request()->is('analytics') ? 'border-b-2 border-slate-800' : '' }}">Analytics</a>
            </li>
        </ul>
    </div>
    <div>
        <form action="/logout" method="POST" class="inline">
            @csrf
            <button type="submit" class="block py-10 text-slate-800 hover:text-emerald-600">
                <i class="fa fa-right-from-bracket fa-xl"></i>
            </button>
        </form>
    </div>
</nav>
