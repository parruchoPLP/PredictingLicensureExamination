@extends('layouts.app')

@section('title', 'File Management')

@section('content')
<section id="indivReport" class="bg-slate-100 dark:bg-slate-800 min-h-screen pr-9 pl-36 py-36 font-arial text-sm">
    <?php

    $studentId = ''; 
    $expectedStatus = 'Expected to Fail'; 
    $reason = 'Needs to improve in advanced topics.';
    $recommendedIntervention = 'It is recommended to focus on improving more in the mentioned areas.';
    $fontColor = ($expectedStatus === 'Expected to Fail') ? 'text-red-700' : 'text-emerald-600';
    ?>

    <div class="bg-white dark:bg-slate-700 rounded-xl shadow-lg p-8"> 
        <p class="font-bold text-xl text-slate-800 dark:text-slate-200"> <i class="fas fa-file mr-6"></i> Individual Report </p> 
        <div class="flex items-center max-w-full mx-auto pt-7">   
            <div class="relative w-full">
                <input 
                    type="text" 
                    id="simple-search" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-200 focus:border-emerald-200 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500" 
                    placeholder="Search student ID..." 
                    autocomplete="off"
                    required 
                    oninput="filterStudent()"
                />
                <svg class="absolute top-1/2 left-3 transform -translate-y-1/2 w-5 h-5 text-gray-400 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 4a7 7 0 017 7c0 1.607-.522 3.09-1.396 4.29l4.587 4.586a1 1 0 01-1.415 1.415l-4.586-4.587A7 7 0 1111 4z" />
                </svg>
                <ul 
                    id="suggestion-list" 
                    class="absolute z-10 w-full text-slate-800 dark:text-slate-200 bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-700 dark:border-gray-600 hidden">
                </ul>
            </div>
            <button type="button" id="search-btn" class="py-2.5 px-8 ms-2 text-sm flex flex-row font-medium rounded-lg bg-emerald-200 hover:bg-emerald-300 dark:bg-emerald-400 dark:hover:bg-emerald-600 focus:ring-2 focus:outline-none focus:ring-emerald-300 dark:focus:ring-emerald-800">
                Search
            </button>
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
                <tbody id="coursesTable">
                    <!-- Dynamic rows will be inserted here -->
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
<script>
    const studentIds = @json($students);
    const studentsData = @json($studentsData);

    function filterStudent() {
        const studentIdInput = document.getElementById('simple-search').value.trim();
        const studentReport = document.getElementById('studReport');
        const studentIdDisplay = document.getElementById('studentIdDisplay');
        const coursesTable = document.getElementById('coursesTable');

        const student = studentsData.find(student => student.id === studentIdInput);

        if (student) {
            studentIdDisplay.textContent = student.id;
            coursesTable.innerHTML = student.courses.map(course => `
                <tr>
                    <td class="border border-gray-300 p-2">${course.courseCode}</td>
                    <td class="border border-gray-300 p-2">${course.courseName}</td>
                    <td class="border border-gray-300 p-2">${course.grade}</td>
                </tr>
            `).join('');
            studentReport.classList.remove('hidden');
            console.log('Student Courses:', student.courses);
        } else {
            studentIdDisplay.textContent = '';
            coursesTable.innerHTML = '<tr><td colspan="3" class="p-2 text-center">No courses found</td></tr>';
            studentReport.classList.add('hidden');
            console.log('Student Courses:', student);
        }
    }
</script>
@endsection