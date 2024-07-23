<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport; // Create this import class
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the request to ensure a file is provided and is of the correct type
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        // Handle the file upload
        if ($request->hasFile('file')) {
            // Get the uploaded file
            $file = $request->file('file');

            // Get the original filename
            $originalName = $file->getClientOriginalName();

            // Store the file in the 'uploads' directory within the 'public' disk
            $relativePath = $file->storeAs('public/uploads', $originalName);

            // Get the full path of the stored file
            $fullPath = storage_path('app/' . $relativePath);

            // Make a POST request to the Flask app for predictions
            $response = Http::post('http://localhost:5000/batchpredict', [
                'file_path' => $fullPath
            ]);

            // Handle the response
            if ($response->successful()) {
                return back()->with(['success' => 'File uploaded successfully', 'full_path' => $fullPath]);
            } else {
                return back()->withErrors(['failed_upload' => 'Error! Check the file format and attributes.']);
            }
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function showFiles()
    {
        $files = Storage::disk('public')->files('uploads');

        $data = [];
        foreach ($files as $file) {
            $data[] = ['file' => basename($file)];
        }

        return view('filemanagement', compact('data'));
    }

    public function report($filename)
    {
        $path = storage_path('app/public/uploads/' . $filename);

        // Load the file and parse its contents
        $data = Excel::toArray(new DataImport, $path);
        $headers = !empty($data[0]) ? array_keys($data[0][0]) : [];

        return view('report', compact('data', 'headers', 'filename'));
    }
}
