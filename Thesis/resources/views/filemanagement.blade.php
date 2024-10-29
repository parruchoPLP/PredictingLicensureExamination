@extends('layouts.app')

@section('title', 'File Management')

@section('content')
<section id="report" class="bg-slate-100 dark:bg-slate-800 min-h-screen pr-9 pl-36 py-36 font-arial">
    <div id="files" class="bg-white dark:bg-slate-700 rounded-xl shadow-lg p-8">
        <p class="font-bold text-xl text-slate-800 dark:text-slate-200"> <i class="fas fa-folder mr-6"></i> Your files </p> 
        @php
            $titles = [
                'Student ID', 'Gender', 'Course Code',
            ];

            $file = [
                ['id' => '21-000001', 'gender' => 'M', 'courseCode' => '1.25',],
            ];

            $headers = [
                'COURSE CODE', 'COURSE DESCRIPTION'
            ];

            $infoPart1 = [
                ['course' => 'ECE 111', 'courseDesc' => 'Calculus I'],
                ['course' => 'ECE 112', 'courseDesc' => 'Calculus II'],
                ['course' => 'ECE 114', 'courseDesc' => 'Differential Equations'],
                ['course' => 'ECE 121', 'courseDesc' => 'Chemistry for Engineers'],
                ['course' => 'ECE 122', 'courseDesc' => 'Physics for Engineers'],
                ['course' => 'ECE 131', 'courseDesc' => 'Computer-Aided Drafting'],
                ['course' => 'ECE 132', 'courseDesc' => 'Engineering Economics'],
                ['course' => 'ECE 133', 'courseDesc' => 'Engineering Management'],
                ['course' => 'ECE 141', 'courseDesc' => 'Physics II'],
                ['course' => 'ECE 143', 'courseDesc' => 'Material Science and Engineering'],
                ['course' => 'ECE 142', 'courseDesc' => 'Computer Programming'],
                ['course' => 'ECE 146', 'courseDesc' => 'Environmental Science and Engineering'],
                ['course' => 'ECE 152', 'courseDesc' => 'Advanced Engineering Mathematics'],
                ['course' => 'ECE 153', 'courseDesc' => 'Electromagnetics'],
            ];

            $infoPart2 = [
                ['course' => 'ECE 156', 'courseDesc' => 'ECE Laws, Contracts, Ethics, Standards And Safety'],
                ['course' => 'ECE 151', 'courseDesc' => 'Electronics 1: Electronic Devices and Circuits'],
                ['course' => 'ECE 154', 'courseDesc' => 'Electronics 2: Electronic Circuit Analysis and Design'],
                ['course' => 'ECE 158', 'courseDesc' => 'Signals, Spectra and Signal Processing'],
                ['course' => 'ECE 155', 'courseDesc' => 'Communications 1: Principles Of Communication Systems'],
                ['course' => 'ECE 162', 'courseDesc' => 'Communications 4: Transmission Media and Antenna System'],
                ['course' => 'ECE 160', 'courseDesc' => 'Digital Electronics 1: Logic Circuits and Switching Theory'],
                ['course' => 'ECE 163', 'courseDesc' => 'Digital Electronics 2: Microprocessor, Microcontroller System and Design'],
                ['course' => 'ECE 164', 'courseDesc' => 'Feedback And Control Systems'],
                ['course' => 'ECE 166', 'courseDesc' => 'Design 1/Capstone Project 1'],
                ['course' => 'ECE 167', 'courseDesc' => 'Design 2/ Capstone Project 2'],
                ['course' => 'ECE 168', 'courseDesc' => 'Seminars/Colloquium'],
                ['course' => 'ECE 202', 'courseDesc' => 'ECE Elective: Industrial Electronics'],
            ];
        @endphp
        <div class="overflow-x-auto pt-7 text-sm">
            @if(empty($data))
                <p class="text-slate-600 text-center dark:text-slate-400 mt-4">No files uploaded.</p>
            @else
                <table class="min-w-full bg-white border dark:bg-slate-800">
                    <thead class="bg-emerald-200 text-slate-800 dark:bg-emerald-700 dark:text-slate-200 text-left uppercase font-bold">
                        <tr>
                            <th class="py-2 px-4 w-3/5">File Name</th>
                            <th class="py-2 px-4 w-1/5"></th>
                            <th class="py-2 px-4 w-1/5"></th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-slate-200">
                        @foreach($data as $row)
                        <tr class="border-b hover:bg-emerald-100 dark:hover:bg-emerald-950">
                            <td class="py-2 px-4">{{ $row['file'] }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ url('/report?file=' . urlencode($row['file'])) }}" class="text-emerald-600 border-b hover:border-emerald-500 py-1 px-3 hover:text-emerald-500 dark:text-emerald-200 hover:dark:text-emerald-500">View Report</a>
                            </td>
                            <td class="py-2 px-4">
                                <form action="{{ route('archive.file') }}" method="POST" onsubmit="return confirm('Are you sure you want to archive this file?');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="file" value="{{ $row['file'] }}">
                                    <button type="submit" class="text-red-800 border-b hover:border-red-500 py-1 px-3 hover:text-red-500 dark:text-red-300 hover:dark:text-red-500">Archive</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <div id="upFiles" class="mt-10 bg-white dark:bg-slate-700 rounded-xl shadow-lg p-8 text-slate-800 dark:text-slate-200">
        <p class="font-bold text-xl"> <i class="fas fa-upload mr-6"></i> Upload file/s </p> 
        <p class="italic mt-7 text-sm"> *Please upload only Excel (xls/csv) files in the specified format. </p> <br>
        <div class="overflow-x-auto"> 
            <table class="min-w-full bg-white text-sm border dark:bg-slate-800">
                <thead class="bg-emerald-200 text-slate-800 dark:bg-emerald-700 dark:text-slate-200 text-left uppercase font-bold">
                    <tr>
                        @foreach($titles as $title)
                        <th class="py-2 px-4">{{ $title }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-slate-200">
                    @foreach($file as $row)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $row['id'] }} <i class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600" data-popover-target="popStudNo"> </i> @include('components.popover', ['id' => 'popStudNo'])</td>
                        <td class="py-2 px-4">{{ $row['gender'] }} <i class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600" data-popover-target="popGender"> </i> @include('components.popover', ['id' => 'popGender'])</td>
                        <td class="py-2 px-4">{{ $row['courseCode'] }} <i class="fa fa-question-circle text-xs hover:text-emerald-400 dark:hover:text-emerald-600" data-popover-target="popCourse"> </i> @include('components.popover', ['id' => 'popCourse']) </td>
                    </tr>
                    @endforeach
                </tbody>
            </table> 
        </div>
        <br>
        <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" class="text-sm" name="file" required> <br>
            <button type="submit" class="mt-8 py-4 px-6 text-sm bg-emerald-200 rounded-lg font-bold hover:bg-emerald-600 hover:text-slate-200 dark:bg-emerald-600 dark:text-slate-200 dark:hover:bg-emerald-300">Upload</button>
        </form> <br>
        <hr>
        <p class="italic mt-7 text-sm"> *Use the following course codes for each course.</p> <br>
        <div class="grid grid-cols-1 mid-lg:grid-cols-2 gap-4 overflow-x-auto">
            <div>
                <table class="bg-white min-w-full text-sm border border-collapse dark:bg-slate-800">
                    <thead class="bg-emerald-200 text-slate-800 dark:bg-emerald-700 dark:text-slate-200 text-left uppercase font-bold">
                        <tr>
                            @foreach($headers as $header)
                            <th class="py-2 px-4 whitespace-nowrap">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-slate-200">
                        @foreach($infoPart1 as $row)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $row['course'] }}</td>
                            <td class="py-2 px-4">{{ $row['courseDesc'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div> 
                <table class="bg-white min-w-full text-sm border border-collapse dark:bg-slate-800">
                    <thead class="bg-emerald-200 text-slate-800 dark:bg-emerald-700 dark:text-slate-200 text-left uppercase font-bold">
                        <tr>
                            @foreach($headers as $header)
                            <th class="py-2 px-4 whitespace-nowrap">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-slate-200">
                        @foreach($infoPart2 as $row)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $row['course'] }}</td>
                            <td class="py-2 px-4">{{ $row['courseDesc'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> <br>
    </div>
</section>
@endsection