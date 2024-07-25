<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport; // Create this import class
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

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
                return back()->with(['success_title' => 'Success', 'success_info' => 'File uploaded successfully', 'full_path' => $fullPath]);
            } else {
                return back()->withErrors(['failed_upload' => 'Error! Check the file format and attributes.']);
            }
        }

        return back()->withErrors(['failed_upload' => 'No file uploaded']);
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

    public function deleteFile(Request $request)
    {
        $fileName = $request->input('file');
        
        // Path to the file
        $filePath = storage_path('app/public/uploads/' . $fileName);
        
        // Check if file exists and delete it
        if (File::exists($filePath)) {
            File::delete($filePath);
            return redirect()->back()->with(['success_title' => 'Delete Success', 'success_info' => 'File deleted successfully!']);
        }

        return redirect()->back()->withErrors(['failed_upload' => 'No file uploaded']);
    }

    public function downloadFile(Request $request)
    {
        $fileName = $request->query('file');

        // Path to the file relative to the 'public' disk
        $filePath = 'uploads/' . $fileName;

        // Check if the file exists on the 'public' disk
        if (Storage::disk('public')->exists($filePath)) {
            /** @var \Illuminate\Filesystem\FilesystemAdapter */
            $fileSystem = Storage::disk('public');
            return $fileSystem->download($filePath);
        }

        return redirect()->back()->withErrors(['failed_download' => 'File not found.']);
    }
}
