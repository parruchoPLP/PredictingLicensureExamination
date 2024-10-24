<!-- resources/views/components/profile.blade.php -->
<a href="{{ url('/acctmanagement') }}" class="flex space-x-4 font-arial transition-transform transform hover:scale-105 cursor-pointer">
    <div class="flex flex-col items-start">
        @if ($name)
            <p class="font-semibold text-slate-900 dark:text-slate-200">{{ $name }}</p>
        @endif
        @if ($role)
            <p class="text-sm text-slate-600 dark:text-slate-400">{{ $role }}</p>
        @endif
    </div>
    <img src="{{ $src }}" alt="{{ $alt }}" class="h-12 w-12 rounded-full object-cover">
</a>
