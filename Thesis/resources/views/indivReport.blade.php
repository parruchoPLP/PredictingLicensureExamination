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
                    oninput="filterStudent()"
                    onfocus="showAllSuggestions()" 
                />
                <svg class="absolute top-1/2 left-3 transform -translate-y-1/2 w-5 h-5 text-gray-400 dark:text-gray-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 4a7 7 0 017 7c0 1.607-.522 3.09-1.396 4.29l4.587 4.586a1 1 0 01-1.415 1.415l-4.586-4.587A7 7 0 1111 4z" />
                </svg>
                <ul 
                    id="suggestion-list" 
                    class="absolute z-10 w-full text-slate-800 dark:text-slate-200 bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-700 dark:border-gray-600 hidden">
                </ul>
            </div>
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
        
        <p id="expectedStatusDisplay"></p>

        <p id="reasonDisplay"></p>

        <p id="interventionDisplay"></p>
    </div>
</section>

<script>
    const studentIds = @json($students); // List of all student IDs
    const studentsData = @json($studentsData); // Full student data

    // Filter and display suggestions based on input
    function filterStudent() {
        const input = document.getElementById('simple-search').value.trim();
        const suggestionList = document.getElementById('suggestion-list');
        const filtered = studentIds.filter(id => id.startsWith(input));

        if (filtered.length > 0 && input !== '') {
            suggestionList.innerHTML = filtered
                .map(id => `<li class="px-4 py-2 cursor-pointer hover:bg-emerald-100 dark:hover:bg-slate-600" onclick="selectStudent('${id}')">${id}</li>`)
                .join('');
            suggestionList.classList.remove('hidden');
        } else {
            suggestionList.classList.add('hidden');
        }
    }

    // Show all student IDs when input is focused
    function showAllSuggestions() {
        const suggestionList = document.getElementById('suggestion-list');
        suggestionList.innerHTML = studentIds
            .map(id => `<li class="px-4 py-2 cursor-pointer hover:bg-emerald-100 dark:hover:bg-slate-600" onclick="selectStudent('${id}')">${id}</li>`)
            .join('');
        suggestionList.classList.remove('hidden');
    }

    // Handle selecting a student ID
    function selectStudent(id) {
        const input = document.getElementById('simple-search');
        const suggestionList = document.getElementById('suggestion-list');
        input.value = id; // Set input value
        suggestionList.classList.add('hidden'); // Hide suggestions
        searchStudent(); // Trigger search
    }

    // Search and display the student report
    // Search and display the student report
function searchStudent() {
    const studentIdInput = document.getElementById('simple-search').value.trim();
    const studentReport = document.getElementById('studReport');
    const studentIdDisplay = document.getElementById('studentIdDisplay');
    const coursesTable = document.getElementById('coursesTable');
    const expectedStatusDisplay = document.getElementById('expectedStatusDisplay');
    const reasonDisplay = document.getElementById('reasonDisplay');
    const interventionDisplay = document.getElementById('interventionDisplay');

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
        
        // Expected status and related logic
        let expectedStatusMessage;
        let expectedStatusClass;
        const performance = student.performance;
        if (performance === 'High') {
            expectedStatusMessage = "Highly Likely to Pass";
            expectedStatusClass = "font-semibold text-emerald-600";
        } else if (performance === 'Low') {
            expectedStatusMessage = "Less Likely to Pass";
            expectedStatusClass = "font-semibold text-red-700";
        }
        expectedStatusDisplay.textContent = `This student is: ${expectedStatusMessage}`;
        expectedStatusDisplay.classList = expectedStatusClass;

        // Reason and potential concerns
        const lowCategories = Object.entries(student.categories)
            .filter(([category, value]) => value === 'Low')
            .map(([category]) => `Category ${category.replace('SUB', '')}`);
        const formattedCategories = lowCategories.length === 1
            ? lowCategories[0]
            : lowCategories.slice(0, -1).join(', ') + ' and ' + lowCategories.slice(-1);
        
        // Generate the reason message
        const reasonTitle = performance === 'High' ? "Potential Areas of Concern:" : "Reason:";
        const reasonMessage = lowCategories.length > 0
            ? `Highly Likely to fail in <span class="font-semibold">${formattedCategories}</span> of the exam.`
            : "None identified.";
        reasonDisplay.innerHTML = `<span class="font-semibold">${reasonTitle}</span> <span class="font-normal">${reasonMessage}</span>`;

        // Suggested action or recommended intervention
        let interventionTitle;
        let interventionMessage;
        if (performance === 'High') {
            interventionTitle = "Suggested Action:";
            interventionMessage = lowCategories.length > 0
                ? "Focus on improving in the topics and courses under the aforementioned areas."
                : "Great progress! Remind the student not to get complacent—this is just a prediction. Encourage them to stay focused.";
        } else {
            interventionTitle = "Recommended Intervention:";
            interventionMessage = "It is recommended to focus on improving more in the topics and courses under the aforementioned areas.";
        }
        interventionDisplay.innerHTML = `<span class="font-semibold">${interventionTitle}</span> <span class="font-normal">${interventionMessage}</span>`;
    } else {
        studentIdDisplay.textContent = '';
        coursesTable.innerHTML = '<tr><td colspan="3" class="p-2 text-center">No courses found</td></tr>';
        expectedStatusDisplay.textContent = '';
        reasonDisplay.textContent = '';
        interventionDisplay.textContent = '';
        studentReport.classList.add('hidden');
    }
}

</script>
@endsection