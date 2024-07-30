@extends('layouts.app')

@section('title', 'Archived Files')

@section('content')
<section id="report" class="bg-slate-100 dark:bg-slate-800 min-h-screen pr-9 pl-36 py-24 font-arial">
    <div id="files" class="bg-white dark:bg-slate-700 rounded-xl shadow-lg p-8">
        <p class="font-bold text-2xl text-slate-800 dark:text-slate-200"> <i class="fas fa-archive mr-6"></i> Archived Files </p> 
        <div class="overflow-x-auto pt-7">
            @if($data->isEmpty())
                <p class="text-slate-600 text-center dark:text-slate-400 mt-4">No archived files.</p>
            @else
                <table class="min-w-full bg-white text-md border dark:bg-slate-800">
                    <thead class="bg-emerald-200 text-slate-800 dark:bg-emerald-700 dark:text-slate-200 text-left uppercase font-bold">
                        <tr>
                            <th class="py-2 px-4 w-2/5">File Name</th>
                            <th class="py-2 px-4 w-1/5">Archived At</th>
                            <th class="py-2 px-4 w-1/5"></th>
                            <th class="py-2 px-4 w-1/5"></th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-slate-200">
                        @foreach($data as $row)
                        <tr class="border-b hover:bg-emerald-100 dark:hover:bg-emerald-950">
                            <td class="py-2 px-4">{{ $row['original_name'] }}</td>
                            <td class="py-2 px-4">{{ $row['archived_at'] }}</td>
                            <td class="py-2 px-4">
                                <form action="{{ route('restore.file') }}" method="POST" onsubmit="return confirm('Are you sure you want to restore this file?');">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="file" value="{{ $row['timestamped_name'] }}">
                                    <button type="submit" class="text-emerald-600 border-b hover:border-emerald-500 py-1 px-3 hover:text-emerald-500 dark:text-emerald-200 hover:dark:text-emerald-500">Restore</button>
                                </form>
                            </td>
                            <td class="py-2 px-4">
                                <form action="{{ route('delete.permanently') }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this file?');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="file" value="{{ $row['timestamped_name'] }}">
                                    <button type="submit" class="text-red-800 border-b hover:border-red-500 py-1 px-3 hover:text-red-500 dark:text-red-300 hover:dark:text-red-500">Delete Permanently</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</section>
@endsection
