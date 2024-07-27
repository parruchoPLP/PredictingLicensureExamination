@extends('layouts.app')

@section('title', 'System Files')

@section('content')
<section id="report" class="bg-slate-100 dark:bg-slate-800 min-h-screen pr-32 pl-48 py-24 font-arial">
    <div id="files" class="bg-white dark:bg-slate-700 rounded-xl shadow-lg p-8">
        <p class="font-bold text-2xl text-slate-800 dark:text-slate-200"> <i class="fas fa-folder mr-6"></i> Training Data Files </p> 
        <p class="italic mt-7"> *Please make sure to reload the predictive model after any changes to the data files. </p>
        @php
            $headers = [
                'Student ID', 'Age', 'Gender', 'Subject 1', 'Subject 2', 'Subject 3', 'Subject 4', 'Subject 5', 'Subject 6', 'Subject 7', 'Passed'
            ];

            $info = [
                ['id' => '21-000001', 'age' => 21, 'gender' => 'M', 'subject1' => '1.25', 'subject2' => '1.50', 'subject3' => '1.25', 'subject4' => '1.50', 'subject5' => '1.50', 'subject6' => '1.50', 'subject7' => '1.50', 'Passed' => '1 or 0'],
            ];
        @endphp
        <div class="overflow-x-auto pt-7">
            @if(empty($data))
                <p class="text-slate-600 text-center dark:text-slate-400 mt-4">No files uploaded.</p>
            @else
                <table class="min-w-full bg-white text-md border dark:bg-slate-800">
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
                                <a href="{{ route('download.systemfile', ['file' => urlencode($row['file'])]) }}" class="text-emerald-600 border-b hover:border-emerald-500 py-1 px-3 hover:text-emerald-500 dark:text-emerald-200 hover:dark:text-emerald-500">Download</a>
                            </td>
                            <td class="py-2 px-4">
                                <form action="{{ route('delete.systemfile') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="file" value="{{ $row['file'] }}">
                                    <button type="submit" class="text-red-800 border-b hover:border-red-500 py-1 px-3 hover:text-red-500 dark:text-red-300 hover:dark:text-red-500">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <form action="{{ route('reload.model') }}" method="POST">
                    @csrf
                    <button type="submit" class="mt-8 py-4 px-6 bg-emerald-200 rounded-lg font-bold hover:bg-emerald-600 hover:text-slate-200 dark:bg-emerald-600 dark:text-slate-200 dark:hover:bg-emerald-300">Reload Predictive Model</button>
                </form>
            @endif
        </div>
    </div>
    <div id="upFiles" class="mt-10 bg-white dark:bg-slate-700 rounded-xl shadow-lg p-8 text-slate-800 dark:text-slate-200 overflow-x-auto">
        <p class="font-bold text-2xl"> <i class="fas fa-upload mr-6"></i> Upload file/s </p> 
        <p class="italic mt-7"> *Please upload only Excel files in the specified format. </p>
        <table class="min-w-full bg-white text-md border border-collapse dark:bg-slate-800">
            <thead class="bg-emerald-200 text-slate-800 dark:bg-emerald-700 dark:text-slate-200 text-left uppercase font-bold sticky top-0 z-10">
                <tr>
                    @foreach($headers as $header)
                    <th class="py-2 px-4 whitespace-nowrap">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="text-gray-700 dark:text-slate-200">
                @foreach($info as $row)
                <tr class="border-b">
                    <td class="py-2 px-4 whitespace-nowrap">{{ $row['id'] }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $row['age'] }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $row['gender'] }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $row['subject1'] }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $row['subject2'] }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $row['subject3'] }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $row['subject4'] }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $row['subject5'] }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $row['subject6'] }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $row['subject7'] }}</td>
                    <td class="py-2 px-4 whitespace-nowrap">{{ $row['Passed'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table><br>
        <form action="{{ route('upload.systemfile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required><br>
            <button type="submit" class="mt-8 py-4 px-6 bg-emerald-200 rounded-lg font-bold hover:bg-emerald-600 hover:text-slate-200 dark:bg-emerald-600 dark:text-slate-200 dark:hover:bg-emerald-300">Upload</button>
        </form>
    </div>
</section>
@endsection