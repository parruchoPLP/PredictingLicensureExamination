@extends('layouts.app')

@section('title', 'Prediction Report')

@section('content')
@if ($errors->any())
    <x-error_alert />
@endif
<section id="report" class="bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 min-h-screen pr-9 pl-36 py-36 font-arial space-y-8">
    <div class="bg-white rounded-xl shadow-md p-8 dark:bg-slate-700 dark:text-slate-200">
        <p class="text-xl text-slate-800 font-bold dark:text-slate-200"> 
            <i class="fas fa-table mr-6"></i> 
            Electronics Engineers Licensure Examination Performance Prediction Report
        </p>
        <div class="pt-8 flex flex-col sm:flex-row justify-between min-w-full text-sm overflow-hidden">
            <p class="flex items-center mb-2 sm:mb-0">
                <i class="fa fa-file mr-2"></i>
                <span>{{ $filename }}</span>
            </p>
            <p class="flex items-center hover:text-emerald-600 hover:cursor-pointer">
                <a href="{{ route('download.file', ['file' => urlencode($filename)]) }}" class="flex items-center underline">
                    Download report
                    <i class="fa fa-download ml-2"></i>
                </a>
            </p>
        </div>
        <br>
        <form method="GET" action="{{ route('report.show') }}" class="mb-3 text-sm w-full max-w-full overflow-hidden" id="filterForm">
    <input type="hidden" name="file" value="{{ $filename }}">

    <div class="flex flex-wrap gap-4">
        <!-- Gender Filter -->
        <div class="w-full sm:w-auto flex items-center">
            <label for="gender" class="block font-semibold mr-3">Gender:</label>
            <select name="gender" id="gender" onchange="document.getElementById('filterForm').submit();" class="w-full text-sm dark:bg-slate-800 rounded-full border-slate-300 focus:ring-emerald-500 focus:bg-emerald-50 focus:border-emerald-200 dark:text-slate-300 dark:focus:bg-transparent">
                <option value="All" {{ request('gender') == 'All' ? 'selected' : '' }}>All</option>
                <option value="M" {{ request('gender') == 'M' ? 'selected' : '' }}>Male</option>
                <option value="F" {{ request('gender') == 'F' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <!-- Result Filter -->
        <div class="w-full sm:w-auto flex items-center">
            <label for="result" class="block font-semibold mr-3">Result:</label>
            <select name="result" id="result" onchange="document.getElementById('filterForm').submit();" class="w-full text-sm dark:bg-slate-800 rounded-full border-slate-300 focus:ring-emerald-500 focus:bg-emerald-50 focus:border-emerald-200 dark:text-slate-300 dark:focus:bg-transparent">
                <option value="All" {{ request('result') == 'All' ? 'selected' : '' }}>All</option>
                <option value="High" {{ request('result') == 'High' ? 'selected' : '' }}>High</option>
                <option value="Low" {{ request('result') == 'Low' ? 'selected' : '' }}>Low</option>
            </select>
        </div>

        <!-- Search by ID -->
        <div class="w-full sm:w-auto flex items-center">
            <label for="id" class="block font-semibold mr-3 whitespace-nowrap">Search by ID:</label>
            <input type="text" name="id" id="id" value="{{ request('id') }}" placeholder="Enter ID"
                class="w-full text-sm dark:bg-slate-800 rounded-full border-slate-300 focus:ring-emerald-500 focus:bg-emerald-50 focus:border-emerald-200 dark:text-slate-300 dark:focus:bg-transparent">
        </div>

        <button type="submit" class="px-4 py-3 text-sm font-semibold whitespace-nowrap dark:text-slate-800 bg-emerald-200 rounded-full hover:bg-emerald-600">
                Search ID
            </button>
    </div>
</form>

        <div class="overflow-x-auto scrollable relative">
            <table class="min-w-full bg-white text-sm border border-collapse">
                <thead class="bg-emerald-200 dark:bg-emerald-700 text-left uppercase font-bold sticky top-0 z-10">
                    <tr>
                        @foreach($headers as $index => $header)
                        <th class="py-2 px-4 whitespace-nowrap @if($loop->first) sticky left-0 z-20 bg-emerald-200 dark:bg-emerald-700 @endif @if($loop->last) sticky right-0 z-20 bg-emerald-200 dark:bg-emerald-700 @endif"
                            data-popover-target="popover-header-{{ $index }}">
                            {{ strtoupper(str_replace('_', ' ', $header)) }}
                            <div id="popover-header-{{ $index }}" data-popover role="tooltip" class="absolute z-50 invisible inline-block w-auto text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">
                                        @if (in_array(strtoupper(str_replace('_', ' ', $header)), ['STUDENT ID', 'GENDER', 'EXPECTED PERFORMANCE']))
                                            FEATURE
                                        @elseif (in_array(strtoupper(str_replace('_', ' ', $header)), ['SUB1', 'SUB2', 'SUB3', 'SUB4']))
                                            EXPECTED PERFORMANCE
                                        @else
                                            {{ strtoupper(str_replace('_', ' ', $header)) }}
                                        @endif
                                    </h3>
                                </div>
                                <div class="px-3 py-2">
                                    <p>
                                        @if (in_array(strtoupper(str_replace('_', ' ', $header)), ['STUDENT ID', 'GENDER', 'EXPECTED PERFORMANCE']))
                                            {{ strtoupper(str_replace('_', ' ', $header)) }}
                                        @elseif (in_array(strtoupper(str_replace('_', ' ', $header)), ['SUB1', 'SUB2', 'SUB3', 'SUB4']))
                                            {{ strtoupper(str_replace('_', ' ', $header)) }}
                                        @else
                                            {{ $courseDictionary[strtoupper(trim(str_replace('_', ' ', $header)))] ?? 'Unknown Feature' }}
                                        @endif
                                    </p>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class=" dark:bg-slate-800">
                    @foreach($paginator as $row)
                    @php
                        $lastValue = end($row);
                    @endphp
                    <tr class="border-b group {{ $lastValue == 'High' ? 'hover:bg-emerald-100 dark:hover:bg-slate-800 dark:hover:text-emerald-400' : ($lastValue == 'Low' ? 'hover:bg-red-100 dark:hover:text-red-400 dark:hover:bg-slate-800' : '') }}">
                        @foreach($row as $key => $value)
                        <td class="py-2 px-4 whitespace-nowrap @if($loop->first) sticky left-0 z-5 bg-white dark:bg-slate-800 {{ $lastValue == 'High' ? 'group-hover:bg-emerald-100 dark:group-hover:bg-slate-800 dark:hover:text-emerald-900 dark:bg-slate-800 dark:group-hover:text-emerald-400' : ($lastValue == 'Low' ? 'group-hover:bg-red-100 dark:group-hover:bg-slate-800 dark:hover:text-red-900 dark:bg-slate-800 dark:group-hover:text-red-400' : '') }} @endif @if($loop->last) sticky right-0 z-5 {{ $key == 'EXPECTED_PERFORMANCE' && $value == 'High' ? 'bg-emerald-100 dark:bg-slate-800 text-black dark:text-emerald-400' : ($key == 'EXPECTED_PERFORMANCE' && $value == 'Low' ? 'bg-red-100 dark:bg-slate-800 text-black dark:text-red-400' : '') }}@endif">
                            {{ $value }}
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $paginator->links() }}
        </div>
    </div>

    <!-- Legend Section -->
    <div class="mt-4 p-4 bg-white dark:bg-slate-800 rounded-lg shadow-md">
        <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">Legend:</p>
        <ul class="text-sm text-gray-600 dark:text-gray-400 mt-2 list-disc list-inside">
            <li><span class="font-bold">High:</span> Highly Likely to Pass</li>
            <li><span class="font-bold">Low:</span> Less Likely to Pass</li>
        </ul>
    </div>
    <h1 class="text-xl font-bold"> Report Summary: </h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl shadow-md p-8 dark:bg-slate-700">
            <h2 class="text-md font-bold">Passing Rate</h2>
                <div class="flex flex-col items-center justify-center p-6">
                    <canvas id="passFailRateChart" class="max-w-[150px] max-h-[150px]"></canvas>
                    <div class="mt-8">
                        <ul id="passFailLegend" class="text-sm">
                            <!-- Legends will be added by JavaScript -->
                        </ul>
                    </div>
                </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-8 dark:bg-slate-700"> 
            <h2 class="text-md font-bold mb-4">Gender Distribution</h2>
            <div id="gender-chart"></div>
        </div>
    </div>
    <div class="grid grid-cols-1 mid-lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-md mid-lg:col-span-2 p-8 dark:bg-slate-700"> 
            <h2 class="text-md font-bold mb-4">Average Grade per Course 
                <button 
                    id="infoButton1"  
                    class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2 bg-transparent border-none"
                    aria-label="Help"
                ></button> @include('components.popover', ['id' => 'popAveCourse'])
            </h2>
            <div id="aveperCourse-chart"></div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-8 dark:bg-slate-700">
            <h2 class="text-md font-bold mb-8">Course/s Needing Support 
                <button 
                    id="infoButton2"  
                    class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600 rounded-full p-2 bg-transparent border-none"
                    aria-label="Help"
                ></button> @include('components.popover', ['id' => 'popCourseSupport'])
            </h2>
            <table class="min-w-full bg-white dark:bg-slate-800 text-sm overflow-hidden shadow-md">
                <thead>
                    <tr class="bg-emerald-200 dark:bg-emerald-700 text-left">
                        <th class="py-2 px-4 font-semibold">Course</th>
                        <th class="py-2 px-4 font-semibold">Average</th>
                    </tr>
                </thead>
                <tbody id="support-table-body">
                    <!-- Rows will be dynamically inserted here -->
                </tbody>
            </table>
        </div>
    </div>
</section>
<script>
    const passFailData = @json($passFailData);
    const genderData = @json($genderData);
    const averageGrades = @json($averageGrades);
    const courseSupport = @json($courseSupport);
</script>
@endsection
