@extends('layouts.app')

@section('title', 'Prediction Report')

@section('content')
<section id="report" class="bg-slate-100 min-h-screen py-36 px-24 font-arial">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <p class="text-2xl text-slate-800 font-bold"> 
            <i class="fas fa-table mr-6"></i> 
            Electronics Engineers Licensure Examination Performance Prediction Report
        </p>
        <div class="mb-4 pt-7 flex justify-between min-w-full text-md">
            <p class="flex items-center">
                <i class="fa fa-file text-slate-800 mr-2"></i>
                <span class="text-slate-800">{{ $filename }}</span>
            </p>
            <p class="flex items-center text-slate-800 hover:text-emerald-600 hover:cursor-pointer">
                <a href="{{ route('download.file', ['file' => urlencode($filename)]) }}" class="flex items-center text-slate-800 hover:text-emerald-600">
                    Download report
                    <i class="fa fa-download ml-2 hover:text-emerald-600"></i>
                </a>
            </p>
        </div>
        <br>
        <form method="GET" action="{{ route('report.show') }}">
            <input type="hidden" name="file" value="{{ $filename }}">
            <label for="gender">Gender:</label>
            <select name="gender" id="gender">
                <option value="All" {{ request('gender') == 'All' ? 'selected' : '' }}>All</option>
                <option value="M" {{ request('gender') == 'M' ? 'selected' : '' }}>Male</option>
                <option value="F" {{ request('gender') == 'F' ? 'selected' : '' }}>Female</option>
            </select>
        
            <label for="result">Result:</label>
            <select name="result" id="result">
                <option value="All" {{ request('result') == 'All' ? 'selected' : '' }}>All</option>
                <option value="Pass" {{ request('result') == 'Pass' ? 'selected' : '' }}>Pass</option>
                <option value="Fail" {{ request('result') == 'Fail' ? 'selected' : '' }}>Fail</option>
            </select>
        
            <button type="submit">Filter</button>
        </form>
        
        <div class="overflow-x-auto scrollable">
            <table class="min-w-full bg-white text-md border border-collapse">
                <thead class="bg-emerald-200 text-slate-800 text-left uppercase font-bold sticky top-0 z-10">
                    <tr>
                        @foreach($headers as $header)
                        <th class="py-2 px-4 whitespace-nowrap @if($loop->first) sticky left-0 z-20 bg-emerald-200 @endif @if($loop->last) sticky right-0 z-20 bg-emerald-200 @endif">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($filteredData as $row)
                    <tr class="border-b group hover:bg-emerald-100">
                        @foreach($row as $key => $value)
                        <td class="py-2 px-4 whitespace-nowrap @if($loop->first) sticky left-0 z-10 bg-white group-hover:bg-emerald-100 @endif @if($loop->last) sticky right-0 z-10 bg-white group-hover:bg-emerald-100 {{ $key == 'result' && $value == 'Pass' ? 'text-green-500' : ($key == 'result' && $value == 'Fail' ? 'text-red-500' : '') }}@endif">{{$value}}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection