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
        $headers = !empty($data[0]) ? array_keys($data[0][0]) : [];

        return view('report', compact('data', 'headers', 'filename'));
    }
}
