
@extends('layouts.app')

@section('title', 'Guest Page')

@section('content')

<button id="darkmode-toggle" class="fixed bottom-4 right-4 z-20 py-3 px-4 text-2xl text-slate-600 bg-white dark:bg-slate-900 dark:text-emerald-300 shadow-lg rounded-xl hover:bg-slate-200 hover:dark:bg-slate-600 transition-transform transform hover:scale-105">
    <i id="darkmode-icon" class="fa fa-moon"></i>
</button>

<section class="bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 flex justify-center items-center min-h-screen font-arial">
    <div class="bg-white dark:bg-slate-700 rounded-xl shadow-lg flex flex-col max-w-4xl w-full relative"> <!-- Added relative positioning here -->
        <!-- Wrapper container for the custom progress bar -->
        <div class="w-full bg-gray-200 dark:bg-slate-900 rounded-t-xl overflow-hidden">
            <!-- Actual progress bar element -->
            <div id="custom-progress" class="bg-emerald-500 h-2 rounded-t-xl" style="width: 0%;"></div>
        </div>

        <!-- Intro Section -->
        <div id="intro-section" class="">
            <div class="border-b border-slate-200 dark:border-slate-800 px-8 py-6 rounded-t-xl"> 
                <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400">Enter Your Grades</p>
            </div>
            <p class="text-md px-8 py-6">
                Please enter your grades in the following technical courses. Answer honestly as the prediction will be based on your inputs.
                <br><br>
                <strong>Note:</strong> This prediction is intended for early guidance and support, and should not be seen as a final determination of your performance.
            </p>
        </div>

        <!-- Result Section -->
        <div id="result-section" class="hidden text-justify">
            <div class="flex justify-between items-center border-b border-slate-200 dark:border-slate-800 px-8 py-6 rounded-t-xl">
                <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400">Predicted Licensure Exam Performance</p>
            </div>
            <div class="p-8">
                <p class="text-md font-medium">Based on your input, your predicted performance in the Electronics Engineers Licensure Exam is:</p>
                <p id="prediction-result" class="text-2xl font-bold my-3"></p>
                <div id="intervention">
                    <p class="text-md font-bold inline-block">Potential Areas of Concern: </p>
                    <p id="potential-areas" class="text-md inline-block"></p>
                    <br> 
                    <p class="text-md font-bold inline-block">Recommendations: </p>
                    <p id="recommendations" class="text-md inline-block"></p>
                </div>
                <p class="text-sm font-medium mt-8">*This prediction is based on your academic performance and is for guidance purposes only.*</p>
            </div>
            <button id="email-btn" class="absolute bottom-4 right-4 py-3 px-8 text-sm font-medium rounded-lg bg-emerald-200 hover:bg-emerald-300 dark:bg-emerald-400 dark:hover:bg-emerald-600 focus:ring-2 focus:outline-none focus:ring-emerald-300 dark:focus:ring-emerald-800">
                Send  Result to Email
            </button>
        </div>

        <!-- Courses Section -->
        <form id="grades-form" action="javascript:void(0)" method="POST" class="w-full"> <!-- Simulating form submission -->
            @csrf
            <div id="dynamic-section">
            </div>

            <!-- Buttons for Pagination -->
            <div class="flex justify-between px-8 py-4" id="pagination-buttons">
                <button type="button" id="back-btn" class="py-2.5 px-8 text-sm font-medium rounded-lg bg-transparent border border-emerald-200 hover:bg-emerald-300 dark:text-white dark:hover:bg-emerald-600 focus:ring-2 focus:outline-none focus:ring-emerald-300 dark:focus:ring-emerald-800">
                    Back
                </button>
                <button type="button" id="next-btn" class="py-2.5 px-8 text-sm font-medium rounded-lg bg-emerald-200 hover:bg-emerald-300 dark:bg-emerald-400 dark:hover:bg-emerald-600 focus:ring-2 focus:outline-none focus:ring-emerald-300 dark:focus:ring-emerald-800">
                    Next
                </button>
            </div>
        </form>
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
            ],
            "Technical Elective Courses:": ["ECE Elective: Industrial Electronics"]
        };

        const categoryData = {
            "Subj1": "Less Likely to Pass",
            "Subj2": "Highly Likely to Pass",
            "Subj3": "Highly Likely to Pass",
            "Subj4": "Highly Likely to Pass"
        };

        const courseGrades = {};
        const dynamicSection = document.getElementById('dynamic-section');
        const introSection = document.getElementById('intro-section');
        const resultSection = document.getElementById('result-section');
        const predictionResult = document.getElementById('prediction-result');
        const backBtn = document.getElementById('back-btn');
        const nextBtn = document.getElementById('next-btn');
        const gradesForm = document.getElementById('grades-form');
        const progress = document.getElementById('custom-progress');
        const courseCategories = Object.keys(courseData);
        let currentSectionIndex = 0;

        const gradeOptions = ["1.00", "1.25", "1.50", "1.75", "2.00", "2.25", "2.50", "2.75", "3.00"];

        const generateTable = (subjects, category) => {
            return `
                <div class="max-h-64 overflow-y-auto border border-slate-300 dark:border-slate-600 rounded-lg">
                    <table class="table-auto w-full text-slate-800 dark:text-slate-200 border-collapse">
                        <thead>
                            <tr class="bg-emerald-100 dark:bg-emerald-700 border-b-2 border-slate-400 dark:border-slate-700">
                                <th class="px-4 py-3 font-large text-left border-r border-slate-300 dark:border-slate-600 w-2/3">Course</th>
                                <th class="px-4 py-3 font-large text-left">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${subjects.map(subject => `
                                <tr>
                                    <td class="px-4 border-b border-r border-slate-300 dark:border-slate-600">${subject}</td>
                                    <td class="px-4 border-b border-slate-300 dark:border-slate-600">
                                        <select name="${subject}" class="grade-select border-transparent focus:ring-transparent focus:border-emerald-300 w-full focus:rounded-lg dark:bg-transparent" required>
                                            <option value="" disabled selected>Select Grade</option>
                                            ${gradeOptions.map(grade => `
                                                <option value="${grade}" class="dark:bg-slate-800" ${courseGrades[subject] === grade ? 'selected' : ''}>${grade}</option>
                                            `).join('')}
                                        </select>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;
        };

        // Function to check if there are any "Less Likely to Pass" categories
        const checkPotentialConcerns = () => {
            const lessLikelyCategories = Object.keys(categoryData).filter(subject => categoryData[subject] === "Less Likely to Pass");
            
            if (lessLikelyCategories.length > 0) {
                const concernedCategory = lessLikelyCategories[0]; // You can loop or choose any from the list
                document.getElementById('potential-areas').textContent = concernedCategory;
                document.getElementById('recommendations').textContent = `Focus on improving in courses under this category.`;
                document.getElementById('intervention').classList.remove('hidden');
            } else {
                document.getElementById('intervention').classList.add('hidden');
            }
        };

        const updateSection = () => {
            if (currentSectionIndex === 0) {
                // Show the intro section
                introSection.classList.remove('hidden');
                dynamicSection.innerHTML = '';
                progress.classList.add('hidden'); // Hide progress in intro section
                nextBtn.setAttribute('type', 'button'); // Keep as a regular button in intro
            } else if (currentSectionIndex === courseCategories.length + 1) {
                // Show the result section
                resultSection.classList.remove('hidden');
                progress.classList.add('hidden'); // Hide progress in result section
                dynamicSection.innerHTML = '';
                introSection.classList.add('hidden');
            } else {
                // For dynamic sections with courses, set "Next" to submit
                introSection.classList.add('hidden');
                resultSection.classList.add('hidden');
                const category = courseCategories[currentSectionIndex - 1]; // Ensure correct category
                const subjects = courseData[category];
                dynamicSection.innerHTML = `
                    <div class="border-b border-slate-200 dark:border-slate-800 px-8 py-6 rounded-t-xl">
                        <p class="font-bold text-xl text-emerald-600 dark:text-emerald-400">${category}</p>
                    </div>
                    <div class="p-8">${generateTable(subjects)}</div>
                `;
                progress.classList.remove('hidden'); // Show progress in course sections
                nextBtn.setAttribute('type', 'submit'); // Change to submit type for dynamic sections
            }

            // Update progress bar
            const progressValue = (currentSectionIndex / courseCategories.length) * 100; // Adjusted the total count for progress
            progress.style.width = `${progressValue}%`;

            progress.classList.remove('bg-gray-200'); // remove any gray background class
            progress.classList.add('bg-emerald-500'); // add the emerald color class
        };
        
        backBtn.addEventListener('click', () => {
            if (currentSectionIndex === 0) {
                window.location.href = '/about'; // Navigate to the About page
            } else {
                currentSectionIndex--;
                updateSection();
            }
        });

        nextBtn.addEventListener('click', () => {
            const gradeSelects = document.querySelectorAll('#dynamic-section select');
            gradeSelects.forEach(select => {
                const subject = select.name;
                const grade = select.value;
                if (grade) {
                    courseGrades[subject] = grade; // Save the selected grade
                }
            });

            const allGradesFilled = Array.from(gradeSelects).every(select => select.value !== "");

            if (allGradesFilled) {
                if (currentSectionIndex < courseCategories.length) {
                    currentSectionIndex++;
                    updateSection();
                }
            } else {
                alert('Please enter grades for all courses before proceeding to the next page.');
            }
        });

        gradesForm.addEventListener('submit', (event) => {
            event.preventDefault();

            // Capture all grades from all sections
            const gradeSelects = document.querySelectorAll('#dynamic-section select');
            gradeSelects.forEach(select => {
                const subject = select.name;
                const grade = select.value;
                if (grade) {
                    courseGrades[subject] = grade; // Save the selected grade
                }
            });

            // Log the captured grades to check if all grades are collected
            console.log('Collected Grades:', courseGrades);

            // Verify that all grades are filled
            const allGradesFilled = Array.from(gradeSelects).every(select => select.value !== "");

            if (allGradesFilled) {
                // Once all grades are captured, show the result section
                resultSection.classList.remove('hidden');
                dynamicSection.innerHTML = '';
                introSection.classList.add('hidden');
                nextBtn.classList.add('hidden');
                backBtn.textContent = 'Home';
                backBtn.innerHTML = '<i class="fa fa-home"></i>'; // Home icon
                backBtn.addEventListener('click', () => window.location.href = '/about'); // Navigate back to About page

                const predictionText = 'Less Likely to Pass'; 
                const isHighlyLikely = predictionText === 'Highly Likely to Pass';

                predictionResult.textContent = predictionText;
                predictionResult.classList.remove('text-red-600', 'text-emerald-600');
                predictionResult.classList.add(isHighlyLikely ? 'text-emerald-600' : 'text-red-600');

                checkPotentialConcerns(); // Check and update potential concerns and recommendations
            } else {
                alert('Please enter grades for all courses before submitting.');
            }
        });

        document.getElementById('email-btn').addEventListener('click', () => {
            const userEmail = prompt("Enter your email address to receive the result:");
            if (userEmail) {
                alert(`Result has been sent to ${userEmail}.`);
            }
        });

        updateSection();
    });
</script>
@endsection
