@extends('layouts.app')

@section('title', 'Prediction Report')

@section('content')
@if ($errors->any())
    <x-error_alert />
@endif
<section id="report" class="bg-slate-100 dark:bg-slate-800 min-h-screen pr-7 pl-32 py-24 font-arial">
    <div class="bg-white rounded-xl shadow-lg p-8 dark:bg-slate-700 dark:text-slate-200">
        <p class="text-2xl text-slate-800 font-bold dark:text-slate-200"> 
            <i class="fas fa-table mr-6"></i> 
            Electronics Engineers Licensure Examination Performance Prediction Report
        </p>
        <div class="mb-4 pt-14 flex justify-between min-w-full text-md text-slate-800 dark:text-slate-200">
            <p class="flex items-center">
                <i class="fa fa-file mr-2"></i>
                <span>{{ $filename }}</span>
            </p>
            <p class="flex items-center hover:text-emerald-600 hover:cursor-pointer">
                <a href="{{ route('download.file', ['file' => urlencode($filename)]) }}" class="flex items-center underline hover:text-emerald-600">
                    Download report
                    <i class="fa fa-download ml-2 hover:text-emerald-600"></i>
                </a>
            </p>
        </div>
        <br>
        <form method="GET" action="{{ route('report.show') }}" class="mb-3">
            <input type="hidden" name="file" value="{{ $filename }}">
            <label for="gender">Gender:</label>
            <select name="gender" id="gender" class="dark:bg-slate-800">
                <option value="All" {{ request('gender') == 'All' ? 'selected' : '' }}>All</option>
                <option value="M" {{ request('gender') == 'M' ? 'selected' : '' }}>Male</option>
                <option value="F" {{ request('gender') == 'F' ? 'selected' : '' }}>Female</option>
            </select>
        
            <label for="result" class="ml-5">Result:</label>
            <select name="result" id="result" class="dark:bg-slate-800">
                <option value="All" {{ request('result') == 'All' ? 'selected' : '' }}>All</option>
                <option value="Pass" {{ request('result') == 'Pass' ? 'selected' : '' }}>Pass</option>
                <option value="Fail" {{ request('result') == 'Fail' ? 'selected' : '' }}>Fail</option>
            </select>

            <label for="id" class="ml-5">Search by ID:</label>
            <input type="text" class="dark:bg-slate-800" name="id" id="id" value="{{ request('id') }}" placeholder="Enter ID">

            <button type="submit" class="ml-4 bg-emerald-200 dark:bg-emerald-700 px-4 py-2 hover:bg-emerald-300 dark:hover:bg-emerald-600">Filter</button>
        </form>
        
        <div class="overflow-x-auto scrollable relative">
            <table class="min-w-full bg-white text-md border border-collapse">
                <thead class="bg-emerald-200 dark:bg-emerald-700 text-slate-800 dark:text-slate-200 text-left uppercase font-bold sticky top-0 z-10">
                    <tr>
                        @foreach($headers as $index => $header)
                        <th class="py-2 px-4 whitespace-nowrap @if($loop->first) sticky left-0 z-20 bg-emerald-200 dark:bg-emerald-700 @endif @if($loop->last) sticky right-0 z-20 bg-emerald-200 dark:bg-emerald-700 @endif"
                            data-popover-target="popover-header-{{ $index }}">
                            {{ $header }}
                            <div id="popover-header-{{ $index }}" data-popover role="tooltip" class="absolute z-50 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Feature</h3>
                                </div>
                                <div class="px-3 py-2">
                                    <p>{{ $header }}</p>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-slate-200 dark:bg-slate-800">
                    @foreach($paginator as $row)
                    @php
                        $lastValue = end($row);
                    @endphp
                    <tr class="border-b group {{ $lastValue == 'Pass' ? 'hover:bg-emerald-100 dark:hover:bg-slate-800 dark:hover:text-emerald-400' : ($lastValue == 'Fail' ? 'hover:bg-red-100 dark:hover:text-red-400 dark:hover:bg-slate-800' : '') }}">
                        @foreach($row as $key => $value)
                        <td class="py-2 px-4 whitespace-nowrap @if($loop->first) sticky left-0 z-5 bg-white dark:bg-slate-800 {{ $lastValue == 'Pass' ? 'group-hover:bg-emerald-100 dark:group-hover:bg-slate-800 dark:hover:text-emerald-900 dark:bg-slate-800 dark:group-hover:text-emerald-400' : ($lastValue == 'Fail' ? 'group-hover:bg-red-100 dark:group-hover:bg-slate-800 dark:hover:text-red-900 dark:bg-slate-800 dark:group-hover:text-red-400' : '') }} @endif @if($loop->last) sticky right-0 z-10 {{ $key == 'predicted_licensure_outcome' && $value == 'Pass' ? 'bg-emerald-100 dark:bg-slate-800 text-black dark:text-emerald-400' : ($key == 'predicted_licensure_outcome' && $value == 'Fail' ? 'bg-red-100 dark:bg-slate-800 text-black dark:text-red-400' : '') }}@endif">
                            {{ $value }}
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $paginator->links() }}
        </div>
    </div>
</section>
@endsection
