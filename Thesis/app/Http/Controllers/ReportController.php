<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport; // Create this import class
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function showReport(Request $request)
    {
        $filename = $request->query('file', 'No file selected'); 
        $path = storage_path('app/public/uploads/' . $filename);

        // Load the file and parse its contents
        $data = Excel::toArray(new DataImport, $path);
        
        // Assuming the first sheet and first row is the header
        $headers = !empty($data[0]) ? array_keys($data[0][0]) : [];

        // Convert the first sheet data to a collection for easier filtering
        $collection = collect($data[0]);

        // Apply filters
        if ($request->has('gender') && $request->query('gender') !== 'All') {
            $collection = $collection->where('gender', $request->query('gender'));
        }

        if ($request->has('result') && $request->query('result') !== 'All') {
            $collection = $collection->where('predicted_licensure_outcome', $request->query('result'));
        }

        // Get filtered data as array
        $filteredData = $collection->toArray();

        return view('report', compact('filteredData', 'headers', 'filename'));
    }


}
