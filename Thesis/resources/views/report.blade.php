<x-navigationbar />
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
                Print report
                <i class="fa fa-print ml-2 hover:text-emerald-600"></i>
            </p>
        </div>

        @php
            $headers = [
                'Student ID', 'Age', 'Gender', 'Subject 1', 'Subject 2', 'Subject 3', 'Subject 4', 'Subject 5', 'Subject 6', 'Subject 7', 'Subject 8', 'Predicted Result'
            ];

            $data = [
                ['id' => '21-000001', 'age' => 21, 'gender' => 'M', 'subject1' => '1.25', 'subject2' => '1.50', 'subject3' => '1.25', 'subject4' => '1.50', 'subject5' => '1.50', 'subject6' => '1.50', 'subject7' => '1.50', 'subject8' => '1.50', 'result' => 'Pass'],
                ['id' => '21-000002', 'age' => 21, 'gender' => 'F', 'subject1' => '1.25', 'subject2' => '1.50', 'subject3' => '1.25', 'subject4' => '1.50', 'subject5' => '1.50', 'subject6' => '1.50', 'subject7' => '1.50', 'subject8' => '1.50', 'result' => 'Pass'],
                ['id' => '21-000003', 'age' => 23, 'gender' => 'M', 'subject1' => '1.25', 'subject2' => '1.50', 'subject3' => '1.25', 'subject4' => '1.50', 'subject5' => '1.50', 'subject6' => '1.50', 'subject7' => '1.50', 'subject8' => '1.50', 'result' => 'Fail'],
                ['id' => '21-000004', 'age' => 23, 'gender' => 'M', 'subject1' => '1.25', 'subject2' => '1.50', 'subject3' => '1.25', 'subject4' => '1.50', 'subject5' => '1.50', 'subject6' => '1.50', 'subject7' => '1.50', 'subject8' => '1.50', 'result' => 'Pass'],
                ['id' => '21-000005', 'age' => 23, 'gender' => 'M', 'subject1' => '1.25', 'subject2' => '1.50', 'subject3' => '1.25', 'subject4' => '1.50', 'subject5' => '1.50', 'subject6' => '1.50', 'subject7' => '1.50', 'subject8' => '1.50', 'result' => 'Pass'],
            ];
        @endphp

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
                    @foreach($data as $row)
                    <tr class="border-b group hover:bg-emerald-100">
                        <td class="py-2 px-4 whitespace-nowrap sticky left-0 z-10 bg-white group-hover:bg-emerald-100">{{ $row['id'] }}</td>
                        <td class="py-2 px-4 whitespace-nowrap group-hover:bg-emerald-100">{{ $row['age'] }}</td>
                        <td class="py-2 px-4 whitespace-nowrap group-hover:bg-emerald-100">{{ $row['gender'] }}</td>
                        <td class="py-2 px-4 whitespace-nowrap group-hover:bg-emerald-100">{{ $row['subject1'] }}</td>
                        <td class="py-2 px-4 whitespace-nowrap group-hover:bg-emerald-100">{{ $row['subject2'] }}</td>
                        <td class="py-2 px-4 whitespace-nowrap group-hover:bg-emerald-100">{{ $row['subject3'] }}</td>
                        <td class="py-2 px-4 whitespace-nowrap group-hover:bg-emerald-100">{{ $row['subject4'] }}</td>
                        <td class="py-2 px-4 whitespace-nowrap group-hover:bg-emerald-100">{{ $row['subject5'] }}</td>
                        <td class="py-2 px-4 whitespace-nowrap group-hover:bg-emerald-100">{{ $row['subject6'] }}</td>
                        <td class="py-2 px-4 whitespace-nowrap group-hover:bg-emerald-100">{{ $row['subject7'] }}</td>
                        <td class="py-2 px-4 whitespace-nowrap group-hover:bg-emerald-100">{{ $row['subject8'] }}</td>
                        <td class="py-2 px-4 whitespace-nowrap sticky right-0 z-10 bg-white group-hover:bg-emerald-100 {{ $row['result'] == 'Pass' ? 'text-green-500' : 'text-red-500' }}">{{ $row['result'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
