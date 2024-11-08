@extends('layouts.app')

@section('title', 'File Management')

@section('content')
<section id="indivReport" class="bg-slate-100 dark:bg-slate-800 min-h-screen pr-9 pl-36 py-36 font-arial text-sm">
    <?php
    $studentIds = [
        '21-00133',
        '21-00134',
        '21-00135',
        '21-00136',
        '21-00137',
        '21-00138',
        '21-00139',
        '21-00140',
        '21-00141',
        '21-00142'
    ];

    $courses = [
        ['courseCode' => 'ECE 111', 'courseName' => 'Calculus I', 'grade' => '1.25'],
        ['courseCode' => 'ECE 112', 'courseName' => 'Calculus II', 'grade' => '1.50'],
        ['courseCode' => 'ECE 114', 'courseName' => 'Differential Equations', 'grade' => '1.75'],
        ['courseCode' => 'ECE 121', 'courseName' => 'Chemistry for Engineers', 'grade' => '2.00'],
        ['courseCode' => 'ECE 122', 'courseName' => 'Physics for Engineers', 'grade' => '1.50'],
        ['courseCode' => 'ECE 111', 'courseName' => 'Calculus I', 'grade' => '1.25'],
        ['courseCode' => 'ECE 112', 'courseName' => 'Calculus II', 'grade' => '1.50'],
        ['courseCode' => 'ECE 114', 'courseName' => 'Differential Equations', 'grade' => '1.75'],
        ['courseCode' => 'ECE 121', 'courseName' => 'Chemistry for Engineers', 'grade' => '2.00'],
        ['courseCode' => 'ECE 163', 'courseName' => 'Digital Electronics 2: Microprocessor, Microcontroller System and Design', 'grade' => '1.50'],
    ];

    $studentId = '21-00133'; 
    $expectedStatus = 'Expected to Fail'; 
    $reason = 'Needs to improve in advanced topics.';
    $recommendedIntervention = 'It is recommended to focus on improving more in the mentioned areas.';
    $fontColor = ($expectedStatus === 'Expected to Fail') ? 'text-red-700' : 'text-emerald-600';
    ?>

    <div class="bg-white dark:bg-slate-700 rounded-xl shadow-lg p-8"> 
        <p class="font-bold text-xl text-slate-800 dark:text-slate-200"> <i class="fas fa-file mr-6"></i> Individual Report </p> 
        <div class="overflow-x-auto pt-7 text-sm grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 ">
            @foreach($studentIds as $index => $studId)    
                <button 
                    class="px-5 py-3 rounded-lg bg-emerald-200 hover:bg-emerald-300 dark:bg-emerald-700 dark:hover:bg-emerald-600 report-toggle-button"
                    data-student-id="{{ $studId }}">
                    {{ $studId }}
                </button>
            @endforeach
        </div>
    </div>

    <div id="studReport" class="mt-10 bg-white dark:bg-slate-700 rounded-xl shadow-lg p-8 space-y-5 hidden"> 
        <p class="font-semibold">Student ID: <span id="studentIdDisplay" class="font-normal"><?= $studentId ?></span></p>
        <div class="max-h-56 overflow-y-auto"> 
            <table class="min-w-full border-collapse border border-gray-300 bg-white dark:bg-slate-800 text-sm">
                <thead class="bg-emerald-200 text-slate-800 dark:bg-emerald-700 dark:text-slate-200 text-left uppercase font-bold">
                    <tr>
                        <th class="border border-gray-300 p-2 whitespace-nowrap">Course Code</th>
                        <th class="border border-gray-300 p-2">Course Name</th>
                        <th class="border border-gray-300 p-2">Grade</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                foreach (array_slice($courses, 0) as $course): ?>
                    <tr>
                        <td class="border border-gray-300 p-2"><?= $course['courseCode'] ?></td>
                        <td class="border border-gray-300 p-2"><?= $course['courseName'] ?></td>
                        <td class="border border-gray-300 p-2"><?= $course['grade'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <p class="<?= $fontColor ?> font-semibold">This student is: <span class="font-normal"><?= $expectedStatus ?></span></p>

        <?php if ($expectedStatus === 'Expected to Fail'): ?>
            <p class="font-semibold">Reason: <span class="font-normal"><?= $reason ?></span></p>
            <p class="font-semibold">Recommended Intervention: <span class="font-normal"><?= $recommendedIntervention ?></span></p>
        <?php else: ?>
            <p class="font-semibold">Potential Areas of Concern: <span class="font-normal"><?= $reason ?></span></p>
            <p class="font-semibold">Suggested Actions: <span class="font-normal"><?= $recommendedIntervention ?></span></p>
        <?php endif; ?>
    </div>
</section>
@endsection
