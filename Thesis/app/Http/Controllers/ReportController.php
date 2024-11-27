<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport; // Create this import class
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\Mail\ResultMail;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
    public function showReport(Request $request)
    {
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
            'ECE 162' => 'COMMUNICATIONS 4: TRANSMISSION MEDIA AND ANTENNA SYSTEM AND DESIGN',
            'ECE 160' => 'DIGITAL ELECTRONICS 1: LOGIC CIRCUITS AND SWITCHING THEORY',
            'ECE 163' => 'DIGITAL ELECTRONICS 2: MICROPROCESSOR, MICROCONTROLLER SYSTEM AND DESIGN',
            'ECE 164' => 'FEEDBACK AND CONTROL SYSTEMS',
            'ECE 166' => 'DESIGN 1/CAPSTONE PROJECT 1',
            'ECE 167' => 'DESIGN 2/ CAPSTONE PROJECT 2',
            'ECE 168' => 'SEMINARS/COLLOQUIUM',
            'ECE 202' => 'ECE ELECTIVE: INDUSTRIAL ELECTRONICS',
        ];

        $filename = $request->query('file', 'No file selected'); 
        $path = storage_path('app/public/uploads/' . $filename);

        // Load the file and parse its contents
        $data = Excel::toArray(new DataImport, $path);
        
        // Assuming the first sheet and first row is the header
        $headers = !empty($data[0]) ? array_keys($data[0][0]) : [];

        // Convert the first sheet data to a collection for easier filtering
        $collection = collect($data[0]);

        // Normalize column names for filtering
        $collection = $collection->map(function ($item) {
            return array_change_key_case(array_map('trim', $item), CASE_UPPER);
        });

        $report = $collection;

        // Apply filters
        if ($request->has('gender') && $request->query('gender') !== 'All') {
            $collection = $collection->where('GENDER', $request->query('gender'));
        }

        if ($request->has('result') && $request->query('result') !== 'All') {
            $collection = $collection->where('EXPECTED_PERFORMANCE', $request->query('result'));
        }

        // Search by ID if not null or an empty string
        if ($request->has('id') && $request->query('id') !== null && $request->query('id') !== '') {
            $collection = $collection->filter(function ($item) use ($request) {
                return stripos($item['STUDENT_ID'], $request->query('id')) !== false;
            });
        }

        // Paginate the filtered data
        $perPage = 15; // Number of items per page
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $filteredData = $collection->forPage($currentPage, $perPage);
        $paginator = new LengthAwarePaginator($filteredData, $collection->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        $totalRecords = $paginator->total();

        // Calculate pass and fail counts
        $passCount = $report->where('EXPECTED_PERFORMANCE', 'High')->count();
        $failCount = $report->where('EXPECTED_PERFORMANCE', 'Low')->count();

        $passFailData = [
            'pass' => $passCount,
            'fail' => $failCount,
            'total' => $totalRecords,
        ];

        $maleCount = $report->where('GENDER', 'M')->count();
        $femaleCount = $report->where('GENDER', 'F')->count();

        $genderData = [
            'male' => $maleCount,
            'female' => $femaleCount,
        ];

        $averageGrades = [];
        foreach ($courseDictionary as $code => $subjectName) {
            $formattedCode = str_replace(' ', '_', $code);

            if ($report->pluck($formattedCode)->isNotEmpty()) {
                $averageGrades[$code] = $report->avg($formattedCode);
            } else {
                $averageGrades[$code] = null;
            }
        }

        $courseSupport = [];
        foreach ($averageGrades as $code => $average) {
            if ($average >= 2.50) {
                $courseSupport[$code] = $average;
            }
        }

        return view('report', compact('paginator', 'headers', 'filename', 'passFailData', 'genderData', 'averageGrades', 'courseSupport', 'courseDictionary'));
    }

    public function dashboard(){
        $modelSummary = base_path('./public/model_summary.csv');

        // Load the file and parse its contents
        $data = Excel::toArray(new DataImport, $modelSummary);
        
        // Assuming the first sheet and first row is the header
        $headers = !empty($data[0]) ? array_keys($data[0][0]) : [];

        // Convert the first sheet data to a collection for easier filtering
        $collection = collect($data[0]);

        // Normalize column names for filtering
        $collection = $collection->map(function ($item) {
            return array_change_key_case(array_map('trim', $item), CASE_UPPER);
        });

        // Initialize arrays to hold the processed data
        $featureImportance = [];
        $modelMetrics = [];
        $averageCourse = [];
        $passingRate = [];

        // Process each row based on the "Metric" column
        foreach ($collection as $row) {
            $metric = $row['METRIC'];
            $feature = $row['FEATURE'];
            $value = $row['VALUE'];

            // Distribute data into arrays based on the "Metric" type
            if ($metric === 'Feature Importance') {
                $featureImportance[$feature] = (float) $value;
            } elseif ($metric === 'Average Grade per Course') {
                $averageCourse[$feature] = (float) $value;
            } elseif ($metric === 'Total Passed' || $metric === 'Total Failed') {
                $passingRate[strtolower(str_replace(' ', '_', $metric))] = (float) $value;
            } else {
                // For model metrics (Accuracy, Precision, Recall, F1 Score)
                $modelMetrics[strtolower(str_replace(' ', '_', $metric))] = number_format((float) $value * 100, 4);
            }
        }

        $featureDupe = $featureImportance;
        arsort($featureDupe);
        $topPredictors = array_keys(array_slice($featureDupe, 0, 5, true));

        return view('dashboard', compact('collection', 'featureImportance', 'averageCourse', 'modelMetrics', 'topPredictors', 'passingRate'));
    }
    public function indivReport(Request $request)
    {
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
            'ECE 162' => 'COMMUNICATIONS 4: TRANSMISSION MEDIA AND ANTENNA SYSTEM AND DESIGN',
            'ECE 160' => 'DIGITAL ELECTRONICS 1: LOGIC CIRCUITS AND SWITCHING THEORY',
            'ECE 163' => 'DIGITAL ELECTRONICS 2: MICROPROCESSOR, MICROCONTROLLER SYSTEM AND DESIGN',
            'ECE 164' => 'FEEDBACK AND CONTROL SYSTEMS',
            'ECE 166' => 'DESIGN 1/CAPSTONE PROJECT 1',
            'ECE 167' => 'DESIGN 2/ CAPSTONE PROJECT 2',
            'ECE 168' => 'SEMINARS/COLLOQUIUM',
            'ECE 202' => 'ECE ELECTIVE: INDUSTRIAL ELECTRONICS',
        ];

        $filename = $request->query('file', 'No file selected'); 
        $path = storage_path('app/public/uploads/' . $filename);

        // Load the file and parse its contents
        $data = Excel::toArray(new DataImport, $path);
        
        // Assuming the first sheet and first row is the header
        $headers = !empty($data[0]) ? array_keys($data[0][0]) : [];

        // Convert the first sheet data to a collection for easier filtering
        $collection = collect($data[0]);

        // Normalize column names for filtering
        $collection = $collection->map(function ($item) {
            return array_change_key_case(array_map('trim', $item), CASE_UPPER);
        });

        // Transform each student row into a structured format
        $studentsData = $collection->map(function ($row) use ($courseDictionary) {
            $studentId = $row['STUDENT_ID'] ?? 'Unknown';

            // Retain original course codes (keys) without alteration
            $courses = collect($row)
            ->except(['STUDENT_ID', 'GENDER', 'SUB1', 'SUB2', 'SUB3', 'SUB4', 'EXPECTED_PERFORMANCE']) // Exclude non-course columns
            ->map(function ($grade, $courseCode) use ($courseDictionary) {
                $originalCourseCode = str_replace('_', ' ', $courseCode); // Avoid transformations
                return [
                    'courseCode' => $originalCourseCode,
                    'courseName' => $courseDictionary[$originalCourseCode] ?? 'Unknown Course',
                    'grade' => $grade ?? 'N/A',
                ];
            })->values()->toArray();

            // Map the categories from SUB1 to SUB4
            $categories = [
                'SUB1' => $row['SUB1'] ?? 'N/A',
                'SUB2' => $row['SUB2'] ?? 'N/A',
                'SUB3' => $row['SUB3'] ?? 'N/A',
                'SUB4' => $row['SUB4'] ?? 'N/A',
            ];

            // Extract the performance
            $performance = $row['EXPECTED_PERFORMANCE'] ?? 'N/A';

            return [
                'id' => $studentId,
                'courses' => $courses,
                'categories' => $categories,
                'performance' => $performance,
            ];
        });

        // Extract all STUDENT_ID values for the dropdown
        $students = $studentsData->pluck('id')->toArray();

        return view('indivReport', compact('students', 'studentsData'));
    }

    public function getPrediction(Request $request)
    {
        $inputData = $request->all();

        // Iterate through the input data and format course codes
        $formattedData = [];
        foreach ($inputData as $courseCode => $grade) {
            // Replace underscores with spaces in the course code
            $formattedCourseCode = str_replace('_', ' ', $courseCode);
            $formattedData[$formattedCourseCode] = $grade;
        }

        // Convert formatted data to JSON format and save to a temporary file
        $jsonData = json_encode($formattedData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $tempFilePath = storage_path('app/temp_input.json');
        file_put_contents($tempFilePath, $jsonData);

        // Send the data to Flask for processing
        $response = Http::withBody($jsonData, 'application/json')
        ->post('http://localhost:5000/individualpredict');

        if ($response->successful()) {
            // Decode the JSON response
            $responseData = $response->json();
    
            // Extract categories and performance
            $categories = [
                'SUB1' => $responseData['SUB1'],
                'SUB2' => $responseData['SUB2'],
                'SUB3' => $responseData['SUB3'],
                'SUB4' => $responseData['SUB4'],
            ];
            $performance = $responseData['PERFORMANCE'];
    
            return view('guestReport', compact('categories', 'performance'));
        } else {
            return back()->withErrors(['failed_upload' => 'Error! Check the data format and attributes.']);
        }
    }

    public function sendResultEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'performance' => 'required|string',
            'reason' => 'required|string',
            'intervention' => 'required|string',
        ]);

        $reason = $request->reason;
        $intervention = $request->intervention;

        function formatString($string, $conditions) {
            foreach ($conditions as $condition) {
                // Check if the string starts with the condition
                if (strpos($string, $condition) === 0) {
                    // Extract the highlighted part and the rest of the string
                    $highlighted = substr($string, 0, strlen($condition));
                    $remaining = substr($string, strlen($condition) + 1); // +1 to skip the colon and space
                    // Return formatted string
                    return "**{$highlighted}** {$remaining}";
                }
            }
            // If no condition matches, return the string as-is
            return $string;
        }

        // Conditions for formatting
        $reasonConditions = ["Potential Areas of Concern:", "Reason:"];
        $interventionConditions = ["Suggested Action:", "Recommended Intervention:"];

        // Format the variables based on their conditions
        $reason = formatString($reason, $reasonConditions);
        $intervention = formatString($intervention, $interventionConditions);

        $emailData = [
            'performance' => $request->performance,
            'reason' => $reason,
            'intervention' => $intervention,
        ];

        Mail::to($request->email)->send(new ResultMail($emailData));

        return response()->json(['message' => 'Email sent successfully.'], 200);
    }
}
