<!-- resources/views/components/profile.blade.php -->
<a href="{{ url('/acctmanagement') }}" class="flex items-center space-x-4 rounded-lg transition-transform transform hover:scale-105 cursor-pointer fixed top-4 right-4 z-0">
    <div class="flex flex-col items-start">
        @if ($name)
            <p class="font-semibold text-gray-800">{{ $name }}</p>
        @endif
        @if ($role)
            <p class="text-sm text-gray-500">{{ $role }}</p>
        @endif
    </div>
    <img src="{{ $src }}" alt="{{ $alt }}" class="h-12 w-12 rounded-full object-cover">
</a>
