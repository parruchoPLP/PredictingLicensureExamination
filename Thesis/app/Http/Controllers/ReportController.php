<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport; // Create this import class
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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
            'ECE 167' => 'ECE ELECTIVE: INDUSTRIAL ELECTRONICS',
            'ECE 168' => 'DESIGN 2/ CAPSTONE PROJECT 2',
            'ECE 202' => 'SEMINARS/COLLOQUIUM',
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

        // Apply filters
        if ($request->has('gender') && $request->query('gender') !== 'All') {
            $collection = $collection->where('GENDER', $request->query('gender'));
        }

        if ($request->has('result') && $request->query('result') !== 'All') {
            $collection = $collection->where('EXPECTED_PERFORMANCE', $request->query('result'));
        }

        // Search by ID if not null or an empty string
        if ($request->has('id') && $request->query('id') !== null && $request->query('id') !== '') {
            $collection = $collection->where('STUDENT_ID', $request->query('id'));
        }

        // Paginate the filtered data
        $perPage = 15; // Number of items per page
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $filteredData = $collection->forPage($currentPage, $perPage);
        $paginator = new LengthAwarePaginator($filteredData, $collection->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('report', compact('paginator', 'headers', 'filename', 'courseDictionary'));
    }
}
