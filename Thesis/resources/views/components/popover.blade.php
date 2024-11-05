<div id="popoverOverlay" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden"></div>

@php
    $popovers = [
        'popOverallPass' => [
            'title' => 'What does the overall passing rate mean?',
            'content' => 'The <b>overall passing rate</b> is the percentage of those students who passed the Electronics Engineers Licensure Examination from the College of Engineering at Pamantasan ng Lungsod ng Pasig from 2017 to 2023, calculated using the training data used by the system but not based on new data from uploaded files in the file management system.
            <br> <br> The overall passing rate is a critical benchmark by which educators and administrators can assess trends in licensure exam performance over time. This understanding helps the college identify areas of improvement, enhance academic support, and refine curriculum development to better prepare students for future licensure exams.',
        ],
        'popFeature' => [
            'title' => 'What is feature importance?',
            'content' => 'The <b>feature importance</b> metric reveals how each of the 27 technical courses in the Electronics and Communications Engineering (ECE) program contributes to predicting a student’s likelihood of passing the Electronics Engineers Licensure Examination. By ranking these courses based on their predictive value, the system highlights which subjects have the greatest impact on exam outcomes.
            <br> <br> Understanding the importance of specific courses allows educators to focus on areas that most affect licensure success, tailoring support and resources for courses with higher predictive weight. This targeted approach can strengthen student performance and improve overall exam readiness.',
        ],
        'popTopPredictors' => [
            'title' => 'What do the top 5 licensure outcome predictors mean?',
            'content' => ' The <b>top 5 licensure outcome predictors</b> represent the five technical ECE courses that most significantly influence a student’s likelihood of passing the Electronics Engineers Licensure Examination. These predictors are identified based on their high feature importance values, indicating that performance in these courses has a strong correlation with exam outcomes.
            <br> <br> By focusing on these top predictors, educators and administrators can prioritize critical areas of study, potentially improving licensure pass rates. Enhanced support, targeted interventions, and curriculum adjustments for these courses could better prepare students for exam success, optimizing educational strategies for impactful results.',
        ],
        'popAveCourse' => [
            'title' => 'What does the average grade per course indicate?',
            'content' => ' The <b>average grade per course</b> indicates the mean score of all students in each of the 27 technical courses within the Electronics and Communications Engineering (ECE) program. This metric reflects overall student performance and comprehension of the material, helping educators identify courses that excel or require additional support.
            <br> <br> Analyzing average grades reveals trends in student performance, informing instructional strategies and resource allocation. Higher average grades in key courses may also correlate with improved performance on the Electronics Engineers Licensure Examination. Thus, understanding this metric is vital for enhancing educational practices and fostering student success.',
        ],
        'popMetrics' => [
            'title' => 'What is the purpose of the performance metrics?',
            'content' => ' The performance metrics of <b>accuracy, precision, recall,</b> and <b>F1 score</b> are critical for evaluating the effectiveness of the predictive model in assessing student outcomes. <b>Accuracy</b> measures the overall percentage of correct predictions made by the model, providing a general indication of its performance. <b>Precision</b> reflects the proportion of true positive results among all positive predictions, showcasing the model’s reliability in identifying successful outcomes. <b>Recall</b> measures the ability to capture all relevant instances, highlighting how effectively the model identifies true positives. The <b>F1 score</b>, which is the harmonic mean of precision and recall, offers a balanced measure of both metrics.
            <br> <br> Analyzing these performance metrics allows educators to assess the predictive capabilities of the model, ensuring interventions are based on reliable data. Understanding these metrics is essential for refining educational strategies and improving student success in the Electronics Engineers Licensure Examination.',
        ],
        'popCourseSupport' => [
            'title' => 'Suggested Interventions',
            'content' => 'This table identifies courses where students may benefit from additional support. These courses, which show lower average performance, indicate potential areas where targeted intervention could be impactful. It is recommended to enhance student resources and provide supplementary instructional materials for these subjects. Additionally, faculty collaboration on teaching strategies and the introduction of peer mentoring could further aid students in achieving improved outcomes in these areas.',
        ],
    ];
@endphp

@foreach ($popovers as $id => $popover)
    <div id="{{ $id }}" role="tooltip" class="fixed z-50 max-w-md w-auto text-sm text-gray-900 dark:text-white transition-opacity duration-300 bg-white border border-gray-200 rounded-xl shadow-lg opacity-0 invisible dark:border-gray-600 dark:bg-gray-800">
        <div class="p-4 bg-emerald-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-emerald-700">
            <p>{{ $popover['title'] }}</p>
        </div>
        <div class="p-4 font-normal text-justify">
            <p>{!! $popover['content'] !!}</p>
        </div>
    </div>
@endforeach

@php
    $studentPopovers = [
        'popStudNo' => ['title' => "Student's ID Number", 'content' => '00-00000'],
        'popGender' => ['title' => "Student's Gender", 'content' => 'M/F'],
        'popCourse' => ['title' => "Student's grade in specific course", 'content' => '0.00'],
        'popPassed' => ['title' => "Student's performance on the licensure exam", 'content' => '1 (Passed) / 0 (Failed)'],
    ];
@endphp

@foreach ($studentPopovers as $id => $popover)
    <div id="{{ $id }}" class="absolute z-10 w-auto text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-xl shadow-sm opacity-0 invisible dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
        <div class="px-3 py-2 bg-emerald-50 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-emerald-700">
            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $popover['title'] }}</h3>
        </div>
        <div class="px-3 py-2">
            <p>{{ $popover['content'] }}</p>
        </div>
    </div>
@endforeach

<div id="popReport" role="tooltip" class="fixed flex flex-row space-x-14 z-50 p-16 w-auto text-sm text-slate-800 dark:text-white transition-opacity duration-300 bg-white border border-gray-200 rounded-xl shadow-lg opacity-0 invisible dark:border-gray-600 dark:bg-gray-800">
    <button class="flex flex-col justify-center items-center rounded-xl w-44 h-40 bg-transparent border-2 border-emerald-200 dark:border-emerald-700 hover:bg-emerald-200 dark:hover:bg-emerald-700">
        <i class="fa fa-file-lines fa-4x mb-4"></i>
        Overview
    </button>
    <button id="infoButton4" class="flex flex-col justify-center items-center rounded-xl w-44 h-40 bg-transparent border-2 border-emerald-200 dark:border-emerald-700 hover:bg-emerald-200 dark:hover:bg-emerald-700">
        <i class="fa fa-user fa-4x mb-4"></i>
        Individual
    </button>
</div>

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
?>

<div id="popIndiv" role="tooltip" class="fixed grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 z-50 p-16 w-auto text-md text-slate-800 dark:text-white transition-opacity duration-300 bg-white border border-gray-200 rounded-xl shadow-lg opacity-0 invisible dark:border-gray-600 dark:bg-gray-800"> 
    @foreach($studentIds as $index => $studId)    
        <button id="infoButton5-{{ $index }}" class="px-5 py-3 rounded-lg bg-emerald-200 hover:bg-emerald-300 dark:bg-emerald-700 dark:hover:bg-emerald-600">
            {{ $studId }}
        </button>
    @endforeach
</div>


<?php
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
$expectedStatus = 'Expected to Pass'; 
$reason = 'Needs to improve in advanced topics.';
$recommendedIntervention = 'It is recommended to focus on improving more in the mentioned areas.';
$fontColor = ($expectedStatus === 'Expected to Fail') ? 'text-red-700' : 'text-emerald-600';
?>

<div id="indivReport" role="tooltip" class="fixed z-50 p-12 w-auto space-y-4 text-md text-slate-800 dark:text-white transition-opacity duration-300 bg-white border border-gray-200 rounded-xl shadow-lg opacity-0 invisible dark:border-gray-600 dark:bg-gray-800"> 
    <p class="font-semibold">Student ID: <span class="font-normal"><?= $studentId ?></span></p>
    <div class="max-h-56 overflow-y-auto"> 
        <table class="min-w-full border-collapse border border-gray-300 bg-white dark:bg-slate-800">
            <thead class="bg-emerald-200 text-slate-800 dark:bg-emerald-700 dark:text-slate-200 text-left uppercase font-bold">
                <tr class="text-gray-700 dark:text-slate-200">
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







