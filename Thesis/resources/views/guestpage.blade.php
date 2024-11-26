@extends('layouts.app')

@section('title', 'Guest Page')

@section('content')

<button id="darkmode-toggle" class="fixed bottom-4 right-4 z-20 py-3 px-4 text-2xl text-slate-600 bg-white dark:bg-slate-900 dark:text-emerald-300 shadow-lg rounded-xl hover:bg-slate-200 hover:dark:bg-slate-600 transition-transform transform hover:scale-105">
    <i id="darkmode-icon" class="fa fa-moon"></i>
</button>

<section class="bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 flex justify-center items-center min-h-screen font-arial">
    <div class="bg-white dark:bg-slate-700 rounded-xl shadow-lg flex flex-col max-w-4xl w-full">
        <div id="dynamic-section">
            <div id="intro-section" class="border-b border-slate-200 dark:border-slate-800 px-8 py-6 rounded-t-xl">
                <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400">Enter Your Grades</p>
            </div>
            <p class="text-md p-8 text-justify">
                Please enter your grades in the following technical courses. Answer honestly as the prediction will be based on your inputs.
                <br><br>
                <strong>Note:</strong> This prediction is intended for early guidance and support, and should not be seen as a final determination of your performance.
            </p>
        </div>

        <div id="result-section" class="hidden text-justify">
            <div class="border-b border-slate-200 dark:border-slate-800 px-8 py-6 rounded-t-xl">
                <p class="text-xl font-bold text-emerald-600">Predicted Licensure Exam Performance</p>
            </div>
            <div class="p-8"> 
                <p class="text-md font-medium">Based on your input, your predicted performance in the Electronics Engineers Licensure Exam is:</p>
                <p id="prediction-result" class="text-2xl font-bold mt-3"></p>
                <p class="text-sm font-medium mt-3">*This prediction is based on your academic performance and is for guidance purposes only.*</p>
            </div>
        </div>

        <div class="flex justify-between px-8 py-6" id="pagination-buttons">
            <button id="back-btn" class="py-2.5 px-8 text-sm font-medium rounded-lg bg-transparent border border-emerald-200 hover:bg-emerald-300 dark:text-white dark:hover:bg-emerald-600 focus:ring-2 focus:outline-none focus:ring-emerald-300 dark:focus:ring-emerald-800">
                Back
            </button>
            <button id="next-btn" class="py-2.5 px-8 text-sm font-medium rounded-lg bg-emerald-200 hover:bg-emerald-300 dark:bg-emerald-400 dark:hover:bg-emerald-600 focus:ring-2 focus:outline-none focus:ring-emerald-300 dark:focus:ring-emerald-800">
                Next
            </button>
        </div>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const courseData = {
            "Mathematics Courses": ["Calculus I", "Calculus II", "Differential Equations"],
            "Natural/Physical Sciences Courses": ["Chemistry For Engineers", "Physics For Engineers"],
            "Basic Engineering Sciences Courses": ["Computer-Aided Drafting", "Engineering Economics", "Engineering Management"],
            "Allied Courses": ["Physics II", "Material Science And Engineering", "Computer Programming", "Environmental Science And Engineering"],
            "Professional Courses": [
                "Advanced Engineering Mathematics", "Electromagnetics", 
                "Ece Laws, Contracts, Ethics, Standards And Safety", 
                "Electronics 1: Electronic Devices And Circuits",
                "Electronics 2: Electronic Circuit Analysis And Design", 
                "Signals, Spectra And Signal Processing", 
                "Communications 1: Principles Of Communication Systems", 
                "Communications 4: Transmission Media And Antenna System", 
                "Digital Electronics 1: Logic Circuits And Switching Theory", 
                "Digital Electronics 2: Microprocessor, Microcontroller System And Design", 
                "Feedback And Control Systems", "Design 1/Capstone Project 1", 
                "Design 2/ Capstone Project 2", "Seminars/Colloquium"
            ]
        };

        const dynamicSection = document.getElementById('dynamic-section');
        const introSection = document.getElementById('intro-section');
        const resultSection = document.getElementById('result-section');
        const predictionResult = document.getElementById('prediction-result');
        const courseCategories = Object.keys(courseData);
        let currentSectionIndex = 0;

        const gradeOptions = ["1.00", "1.25", "1.50", "1.75", "2.00", "2.25", "2.50", "2.75", "3.00"];

        const generateTable = (subjects) => {
            return `
                <div class="max-h-64 overflow-y-auto border border-slate-300 dark:border-slate-600 rounded-lg">
                    <table class="table-auto w-full text-slate-800 dark:text-slate-200 border-collapse">
                        <thead>
                            <tr class="bg-emerald-100 dark:bg-emerald-700 border-b-2 border-slate-400 dark:border-slate-700">
                                <th class="px-4 py-3 font-large text-left border-r border-slate-300 dark:border-slate-600 w-4/5">Course</th>
                                <th class="px-4 py-3 font-large text-left">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${subjects.map(subject => `
                                <tr>
                                    <td class="px-4 border-b border-r border-slate-300 dark:border-slate-600">${subject}</td>
                                    <td class="px-4 border-b border-slate-300 dark:border-slate-600">
                                        <select class="grade-select border-transparent focus:ring-transparent focus:border-emerald-300 w-full focus:rounded-lg dark:bg-transparent">
                                            ${gradeOptions.map(grade => `<option class="dark:bg-slate-800">${grade}</option>`).join('')}
                                        </select>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;
        };

        const updateSection = () => {
            if (currentSectionIndex === 0) {
                introSection.classList.remove('hidden');
            } else {
                introSection.classList.add('hidden');
                const category = courseCategories[currentSectionIndex - 1];
                const subjects = courseData[category];
                dynamicSection.innerHTML = `
                    <div class="border-b border-slate-200 dark:border-slate-800 px-8 py-6 rounded-t-xl">
                        <p class="font-bold text-xl text-emerald-600 dark:text-emerald-400">${category}</p>
                    </div>
                    <div class="p-8">${generateTable(subjects)}</div>
                `;

                // Change "Next" button to "Submit" for Professional Courses
                if (currentSectionIndex === courseCategories.length) {
                    document.getElementById('next-btn').textContent = 'Submit';
                } else {
                    document.getElementById('next-btn').textContent = 'Next';
                }
            }
        };

        document.getElementById('back-btn').addEventListener('click', () => {
            if (currentSectionIndex === 0) {
                window.location.href = '/about';
            } else {
                currentSectionIndex--;
                updateSection();
            }
        });

        document.getElementById('next-btn').addEventListener('click', () => {
            if (currentSectionIndex === courseCategories.length) {
                // Show result prediction and hide the "Next" button
                const prediction = "Highly Likely to Pass"; 
                
                predictionResult.textContent = prediction;

                if (prediction === "Highly Likely to Pass") {
                    predictionResult.classList.add('text-emerald-600');
                    predictionResult.classList.remove('text-red-400');
                } else {
                    predictionResult.classList.add('text-red-400');
                    predictionResult.classList.remove('text-emerald-600');
                }

                dynamicSection.classList.add('hidden');
                resultSection.classList.remove('hidden');
                // Hide the "Next" button in result section
                document.getElementById('pagination-buttons').innerHTML = `
                    <button id="back-btn-result" class="py-2.5 px-8 text-sm font-medium rounded-lg bg-transparent border border-emerald-200 hover:bg-emerald-300 dark:text-white dark:hover:bg-emerald-600 focus:ring-2 focus:outline-none focus:ring-emerald-300 dark:focus:ring-emerald-800">
                        Back
                    </button>
                `;
            } else {
                currentSectionIndex++;
                updateSection();
            }
        });

        // Back button in result section
        document.body.addEventListener('click', function(event) {
            if (event.target.id === 'back-btn-result') {
                resultSection.classList.add('hidden');
                dynamicSection.classList.remove('hidden');
                currentSectionIndex = courseCategories.length - 1; // Stay at the last section
                updateSection();
            }
        });

        updateSection(); // Initialize the first section
    });
</script>

@endsection
