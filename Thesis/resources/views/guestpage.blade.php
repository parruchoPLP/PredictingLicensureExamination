@extends('layouts.app')

@section('title', 'Guest Page')

@section('content')
<style>
    /* Fade-in and fade-out animations for elements */
    .fade-in {
        opacity: 0;
        animation: fadeIn 0.5s forwards;
    }

    .fade-out {
        opacity: 1;
        animation: fadeOut 0.5s forwards;
    }

    /* Keyframes for fade animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
</style>
<button id="darkmode-toggle" class="fixed bottom-4 right-4 z-20 py-3 px-4 text-2xl text-slate-600 bg-white dark:bg-slate-900 dark:text-emerald-300 shadow-lg rounded-xl hover:bg-slate-200 hover:dark:bg-slate-600 transition-transform transform hover:scale-105">
    <i id="darkmode-icon" class="fa fa-moon"></i>
</button>
<button id="home" class="fixed top-4 right-4 z-20 py-3 px-4 text-2xl text-slate-600 bg-white dark:bg-slate-900 dark:text-emerald-300 shadow-lg rounded-xl hover:bg-slate-200 hover:dark:bg-slate-600 transition-transform transform hover:scale-105">
    <i class="fa fa-home"></i>
</button>

<?php
    $grades = ["1.00", "1.25", "1.50", "1.75", "2.00", "2.25", "2.50", "2.75", "3.00"];
    $courseDictionary = [
            'ECE 111' => 'CALCULUS I',
            'ECE 112' => 'CALCULUS II',
            'ECE 114' => 'DIFFERENTIAL EQUATIONS',
            'ECE 121' => 'CHEMISTRY FOR ENGINEERS',
            'ECE 122' => 'PHYSICS FOR ENGINEERS',
            'ECE 131' => 'COMPUTER AIDED DRAFTING',
            'ECE 132' => 'ENGINEERING ECONOMICS',
            'ECE 133' => 'ENGINEERING MANAGEMENT',
            'ECE 141' => 'PHYSICS II',
            'ECE 143' => 'MATERIAL SCIENCE AND ENGINEERING',
            'ECE 142' => 'COMPUTER PROGRAMMING',
            'ECE 146' => 'ENVIRONMENTAL SCIENCE AND ENGINEERING',
            'ECE 152' => 'ADVANCED ENGINEERING MATHEMATICS',
            'ECE 153' => 'ELECTROMAGNETICS',
            'ECE 156' => 'ECE LAWS, CONTRACTS, ETHICS, STANDARDS AND SAFETY',
            'ECE 151' => 'ELECTRONICS 1: ELECTRONIC DEVICES AND CIRCUITS',
            'ECE 154' => 'ELECTRONICS 2: ELECTRONIC CIRCUIT ANALYSIS AND DESIGN',
            'ECE 158' => 'SIGNALS, SPECTRA AND SIGNAL PROCESSING',
            'ECE 155' => 'COMMUNICATIONS 1: PRINCIPLES OF COMMUNICATION SYSTEMS',
            'ECE 162' => 'COMMUNICATIONS 4: TRANSMISSION MEDIA AND ANTENNA SYSTEM',
            'ECE 160' => 'DIGITAL ELECTRONICS 1: LOGIC CIRCUITS AND SWITCHING THEORY',
            'ECE 163' => 'DIGITAL ELECTRONICS 2: MICROPROCESSOR, MICROCONTROLLER SYSTEM AND DESIGN',
            'ECE 164' => 'FEEDBACK AND CONTROL SYSTEMS',
            'ECE 166' => 'DESIGN 1/CAPSTONE PROJECT 1',
            'ECE 167' => 'DESIGN 2/ CAPSTONE PROJECT 2',
            'ECE 168' => 'SEMINARS/COLLOQUIUM',
            'ECE 202' => 'ECE ELECTIVE: INDUSTRIAL ELECTRONICS',
        ];
    $mathcourse = ["Calculus I", "Calculus II", "Differential Equations"];
    $natscicourse = ["Chemistry For Engineers", "Physics For Engineers"];
    $basenscicourse = ["Computer Aided Drafting", "Engineering Economics", "Engineering Management"];
    $alliedcourse = ["Physics II", "Material Science And Engineering", "Computer Programming", "Environmental Science And Engineering"];
    $profcourse = [
                "Advanced Engineering Mathematics", "Electromagnetics", 
                "ECE Laws, Contracts, Ethics, Standards And Safety", 
                "Electronics 1: Electronic Devices And Circuits",
                "Electronics 2: Electronic Circuit Analysis And Design", 
                "Signals, Spectra And Signal Processing", 
                "Communications 1: Principles Of Communication Systems", 
                "Communications 4: Transmission Media And Antenna System", 
                "Digital Electronics 1: Logic Circuits And Switching Theory", 
                "Digital Electronics 2: Microprocessor, Microcontroller System And Design", 
                "Feedback And Control Systems", "Design 1/Capstone Project 1", 
                "Design 2/ Capstone Project 2", "Seminars/Colloquium"
        ];
    $techelecourse = ["ECE Elective: Industrial Electronics"];
?>

<section class="bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 flex justify-center items-center min-h-screen font-arial">
    <div id="surveyForm" class="bg-white dark:bg-slate-700 rounded-xl shadow-lg flex flex-col max-w-4xl w-full relative fade-in">
        <!-- Wrapper container for the custom progress bar -->
        <div class="w-full bg-gray-200 dark:bg-slate-900 rounded-t-xl overflow-hidden">
            <!-- Actual progress bar element -->
            <div id="custom-progress" class="bg-emerald-500 h-2 rounded-t-xl" style="width: 0%;"></div>
        </div>

        <!-- Progress Steps -->
        <div class="flex justify-center steps">
            @for($i = 0; $i < 12; $i++)
                <div class="step @if($i == 0) step-primary @endif"></div>
            @endfor
        </div>

        <form id="surveyForm" action="{{ route('individual.predict') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Intro Section -->
            <div id="intro-section" class="">
                <div class="border-b border-slate-200 dark:border-slate-800 px-8 pb-6 rounded-t-xl"> 
                    <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400">Enter Your Grades</p>
                </div>
                <p class="text-md px-8 mt-8">
                    Please enter your grades in the following technical courses. Answer honestly as the prediction will be based on your inputs.
                    <br><br>
                    <strong>Note:</strong> This prediction is intended for early guidance and support, and should not be seen as a final determination of your performance.
                </p>
            </div>

            <div id="step1" class="hidden step-content">
                <div class="border-b border-slate-200 dark:border-slate-800 px-8 py-6 rounded-t-xl">
                    <p class="font-bold text-xl text-emerald-600 dark:text-emerald-400">Mathematics Courses</p>
                </div>
                <div class="max-h-64 overflow-y-auto border border-slate-300 dark:border-slate-600 rounded-lg m-8">
                    <table class="table-auto w-full text-slate-800 dark:text-slate-200 border-collapse">
                        <thead>
                            <tr class="bg-emerald-100 dark:bg-emerald-700 border-b-2 border-slate-400 dark:border-slate-700">
                                <th class="px-4 py-3 font-large text-left border-r border-slate-300 dark:border-slate-600 w-2/3">Course</th>
                                <th class="px-4 py-3 font-large text-left">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mathcourse as $course)
                            <tr>
                                <td class="px-4 border-b border-r border-slate-300 dark:border-slate-600">{{ $course }}</td>
                                <td class="px-4 border-b border-slate-300 dark:border-slate-600">
                                    @foreach ($courseDictionary as $key => $value)
                                        @if ($value == strtoupper($course))
                                        <select id="mathcourses" name="{{ $key }}" class="grade-select border-transparent focus:ring-transparent focus:border-emerald-300 w-full focus:rounded-lg dark:bg-transparent" required>
                                        @endif
                                    @endforeach
                                        <option class="text-slate-900 dark:text-white dark:bg-slate-800" value="" disabled selected>Select Grade</option>
                                        @foreach($grades as $grade)
                                            <option value="{{ $grade }}" class="dark:bg-slate-800" >{{ $grade }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="step2" class="hidden step-content">
                <div class="border-b border-slate-200 dark:border-slate-800 px-8 pb-6 rounded-t-xl">
                    <p class="font-bold text-xl text-emerald-600 dark:text-emerald-400">Natural/Physical Sciences Courses</p>
                </div>
                <div class="max-h-64 overflow-y-auto border border-slate-300 dark:border-slate-600 rounded-lg m-8">
                    <table class="table-auto w-full text-slate-800 dark:text-slate-200 border-collapse">
                        <thead>
                            <tr class="bg-emerald-100 dark:bg-emerald-700 border-b-2 border-slate-400 dark:border-slate-700">
                                <th class="px-4 py-3 font-large text-left border-r border-slate-300 dark:border-slate-600 w-2/3">Course</th>
                                <th class="px-4 py-3 font-large text-left">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($natscicourse as $course)
                            <tr>
                                <td class="px-4 border-b border-r border-slate-300 dark:border-slate-600">{{ $course }}</td>
                                <td class="px-4 border-b border-slate-300 dark:border-slate-600">
                                    @foreach ($courseDictionary as $key => $value)
                                        @if ($value == strtoupper($course))
                                        <select id="natscicourses" name="{{ $key }}" class="grade-select border-transparent focus:ring-transparent focus:border-emerald-300 w-full focus:rounded-lg dark:bg-transparent" required>
                                        @endif
                                    @endforeach
                                        <option class="text-slate-900 dark:text-white dark:bg-slate-800" value="" disabled selected>Select Grade</option>
                                        @foreach($grades as $grade)
                                            <option value="{{ $grade }}" class="dark:bg-slate-800" >{{ $grade }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="step3" class="hidden step-content">
                <div class="border-b border-slate-200 dark:border-slate-800 px-8 pb-6 rounded-t-xl">
                    <p class="font-bold text-xl text-emerald-600 dark:text-emerald-400">Basic Engineering Sciences Courses</p>
                </div>
                <div class="max-h-64 overflow-y-auto border border-slate-300 dark:border-slate-600 rounded-lg m-8">
                    <table class="table-auto w-full text-slate-800 dark:text-slate-200 border-collapse">
                        <thead>
                            <tr class="bg-emerald-100 dark:bg-emerald-700 border-b-2 border-slate-400 dark:border-slate-700">
                                <th class="px-4 py-3 font-large text-left border-r border-slate-300 dark:border-slate-600 w-2/3">Course</th>
                                <th class="px-4 py-3 font-large text-left">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($basenscicourse as $course)
                            <tr>
                                <td class="px-4 border-b border-r border-slate-300 dark:border-slate-600">{{ $course }}</td>
                                <td class="px-4 border-b border-slate-300 dark:border-slate-600">
                                    @foreach ($courseDictionary as $key => $value)
                                        @if ($value == strtoupper($course))
                                        <select id="basenscicourses" name="{{ $key }}" class="grade-select border-transparent focus:ring-transparent focus:border-emerald-300 w-full focus:rounded-lg dark:bg-transparent" required>
                                        @endif
                                    @endforeach
                                        <option class="text-slate-900 dark:text-white dark:bg-slate-800" value="" disabled selected>Select Grade</option>
                                        @foreach($grades as $grade)
                                            <option value="{{ $grade }}" class="dark:bg-slate-800" >{{ $grade }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="step4" class="hidden step-content">
                <div class="border-b border-slate-200 dark:border-slate-800 px-8 pb-6 rounded-t-xl">
                    <p class="font-bold text-xl text-emerald-600 dark:text-emerald-400">Allied Courses</p>
                </div>
                <div class="max-h-64 overflow-y-auto border border-slate-300 dark:border-slate-600 rounded-lg m-8">
                    <table class="table-auto w-full text-slate-800 dark:text-slate-200 border-collapse">
                        <thead>
                            <tr class="bg-emerald-100 dark:bg-emerald-700 border-b-2 border-slate-400 dark:border-slate-700">
                                <th class="px-4 py-3 font-large text-left border-r border-slate-300 dark:border-slate-600 w-2/3">Course</th>
                                <th class="px-4 py-3 font-large text-left">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alliedcourse as $course)
                            <tr>
                                <td class="px-4 border-b border-r border-slate-300 dark:border-slate-600">{{ $course }}</td>
                                <td class="px-4 border-b border-slate-300 dark:border-slate-600">
                                    @foreach ($courseDictionary as $key => $value)
                                        @if ($value == strtoupper($course))
                                        <select id="alliedcourses" name="{{ $key }}" class="grade-select border-transparent focus:ring-transparent focus:border-emerald-300 w-full focus:rounded-lg dark:bg-transparent" required>
                                        @endif
                                    @endforeach
                                        <option class="text-slate-900 dark:text-white dark:bg-slate-800" value="" disabled selected>Select Grade</option>
                                        @foreach($grades as $grade)
                                            <option value="{{ $grade }}" class="dark:bg-slate-800" >{{ $grade }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="step5" class="hidden step-content">
                <div class="border-b border-slate-200 dark:border-slate-800 px-8 pb-6 rounded-t-xl">
                    <p class="font-bold text-xl text-emerald-600 dark:text-emerald-400">Professional Courses</p>
                </div>
                <div class="max-h-64 overflow-y-auto border border-slate-300 dark:border-slate-600 rounded-lg m-8">
                    <table class="table-auto w-full text-slate-800 dark:text-slate-200 border-collapse">
                        <thead>
                            <tr class="bg-emerald-100 dark:bg-emerald-700 border-b-2 border-slate-400 dark:border-slate-700">
                                <th class="px-4 py-3 font-large text-left border-r border-slate-300 dark:border-slate-600 w-2/3">Course</th>
                                <th class="px-4 py-3 font-large text-left">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($profcourse as $course)
                            <tr>
                                <td class="px-4 border-b border-r border-slate-300 dark:border-slate-600">{{ $course }}</td>
                                <td class="px-4 border-b border-slate-300 dark:border-slate-600">
                                    @foreach ($courseDictionary as $key => $value)
                                        @if ($value == strtoupper($course))
                                        <select id="profcourses" name="{{ $key }}" class="grade-select border-transparent focus:ring-transparent focus:border-emerald-300 w-full focus:rounded-lg dark:bg-transparent" required>
                                        @endif
                                    @endforeach
                                        <option class="text-slate-900 dark:text-white dark:bg-slate-800" value="" disabled selected>Select Grade</option>
                                        @foreach($grades as $grade)
                                            <option value="{{ $grade }}" class="dark:bg-slate-800" >{{ $grade }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="step6" class="hidden step-content">
                <div class="border-b border-slate-200 dark:border-slate-800 px-8 pb-6 rounded-t-xl">
                    <p class="font-bold text-xl text-emerald-600 dark:text-emerald-400">Technical Elective Courses</p>
                </div>
                <div class="max-h-64 overflow-y-auto border border-slate-300 dark:border-slate-600 rounded-lg m-8">
                    <table class="table-auto w-full text-slate-800 dark:text-slate-200 border-collapse">
                        <thead>
                            <tr class="bg-emerald-100 dark:bg-emerald-700 border-b-2 border-slate-400 dark:border-slate-700">
                                <th class="px-4 py-3 font-large text-left border-r border-slate-300 dark:border-slate-600 w-2/3">Course</th>
                                <th class="px-4 py-3 font-large text-left">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($techelecourse as $course)
                            <tr>
                                <td class="px-4 border-b border-r border-slate-300 dark:border-slate-600">{{ $course }}</td>
                                <td class="px-4 border-b border-slate-300 dark:border-slate-600">
                                    @foreach ($courseDictionary as $key => $value)
                                        @if ($value == strtoupper($course))
                                        <select id="techelecourses" name="{{ $key }}" class="grade-select border-transparent focus:ring-transparent focus:border-emerald-300 w-full focus:rounded-lg dark:bg-transparent" required>
                                        @endif
                                    @endforeach
                                        <option class="text-slate-900 dark:text-white dark:bg-slate-800" value="" disabled selected>Select Grade</option>
                                        @foreach($grades as $grade)
                                            <option value="{{ $grade }}" class="dark:bg-slate-800" >{{ $grade }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Navigation Buttons -->
            <div class="flex justify-between px-8 pt-4 pb-8">
                <button type="button" id="prevStep" class="hidden py-2.5 px-8 text-sm font-medium rounded-lg bg-transparent border border-emerald-200 hover:bg-emerald-300 dark:text-white dark:hover:bg-emerald-600 focus:ring-2 focus:outline-none focus:ring-emerald-300 dark:focus:ring-emerald-800">
                    Previous
                </button>
                <div class="invisible"></div>
                <div>
                    <button type="button" id="nextStep" class="py-2.5 px-8 text-sm font-medium rounded-lg bg-emerald-200 hover:bg-emerald-300 dark:bg-emerald-400 dark:hover:bg-emerald-600 focus:ring-2 focus:outline-none focus:ring-emerald-300 dark:focus:ring-emerald-800" disabled>
                        Next
                    </button>
                    <button type="submit" id="submitButton" class="py-2.5 px-8 text-sm font-medium rounded-lg bg-emerald-200 hover:bg-emerald-300 dark:bg-emerald-400 dark:hover:bg-emerald-600 focus:ring-2 focus:outline-none focus:ring-emerald-300 dark:focus:ring-emerald-800">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const steps = Array.from(document.querySelectorAll(".step"));
        const contents = Array.from(document.querySelectorAll(".step-content"));
        let currentStep = 0;

        const introSection = document.getElementById("intro-section");

        const nextButton = document.getElementById("nextStep");
        const prevButton = document.getElementById("prevStep");
        const submitButton = document.getElementById("submitButton");

        const surveyForm = document.getElementById("surveyForm");

        const progress = document.getElementById('custom-progress');

        const homebtn = document.getElementById("home");
        homebtn.addEventListener('click', () => window.location.href = '/about'); // Navigate back to About page

        function toggleButtons() {
            prevButton.classList.toggle("hidden", currentStep === 0);
            nextButton.classList.toggle("hidden", currentStep === contents.length - 1);
            submitButton.classList.toggle("hidden", currentStep !== contents.length - 1);
            nextButton.disabled = true;
        }

        function updateStep() {
            if (currentStep === 0) {
                introSection.classList.remove("hidden");
            } else {
                introSection.classList.add("hidden");
            }
            contents.forEach((content, index) => {
                content.classList.toggle("hidden", index !== currentStep);
                steps[index].classList.toggle("step-primary", index === currentStep);
            });
            const progressValue = ((currentStep + 1) / 6) * 100; // Adjusted the total count for progress
            progress.style.width = `${progressValue}%`;

            progress.classList.remove('bg-gray-200'); // remove any gray background class
            progress.classList.add('bg-emerald-500'); // add the emerald color class
            toggleButtons();
            checkIfOptionSelected();
        }

        function checkIfOptionSelected() {
            const selectElements = Array.from(contents[currentStep]?.querySelectorAll("select") || []);
    
            // Check if all select elements have a value
            const allSelected = selectElements.every(select => select.value);

            // Disable or enable the Next button based on whether all selects are filled
            nextButton.disabled = !allSelected;

            // Add event listeners to each select to monitor changes
            selectElements.forEach(select => {
                select.addEventListener("change", () => {
                    const allSelected = selectElements.every(select => select.value);
                    nextButton.disabled = !allSelected;
                });
            });
        }

        nextButton.addEventListener("click", () => {
            if (currentStep < contents.length - 1) {
                currentStep++;
                updateStep();
            }
        });

        prevButton.addEventListener("click", () => {
            if (currentStep > 0) {
                currentStep--;
                updateStep();
            }
        });

        updateStep();
    });
</script>
@endsection