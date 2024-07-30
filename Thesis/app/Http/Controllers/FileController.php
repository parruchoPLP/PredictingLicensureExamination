<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DataImport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\ArchiveFile;
use Illuminate\Support\Str;

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
    
            // Define the relative path
            $relativePath = 'public/uploads/' . $originalName;
    
            // Check if the file already exists
            if (Storage::exists($relativePath)) {
                return back()->withErrors(['failed_upload' => 'A file with the same name already exists.']);
            }
    
            // Store the file in the 'uploads' directory within the 'public' disk
            $file->storeAs('public/uploads', $originalName);
    
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
                File::delete($fullPath);
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

    public function archiveFile(Request $request)
    {
        $fileName = $request->input('file');
        $filePath = storage_path('app/public/uploads/' . $fileName);
        $archiveFolder = storage_path('app/public/archive_folder/');
    
        if (!File::exists($archiveFolder)) {
            File::makeDirectory($archiveFolder, 0755, true);
        }
    
        // Check if file exists and move it to the recently deleted folder
        if (File::exists($filePath)) {
            $timestamp = Carbon::now()->format('Ymd_His');
            $uniqueFileName = $timestamp . '_' . $fileName;

            $archivedFilePath = $archiveFolder . $uniqueFileName;
    
            // Move the file
            File::move($filePath, $archivedFilePath);
    
            // Save metadata to database
            ArchiveFile::create([
                'original_name' => $fileName,
                'timestamped_name' => $uniqueFileName,
                'path' => 'public/archive_folder/' . $fileName,
                'archived_at' => Carbon::now(),
            ]);
    
            return redirect()->back()->with(['success_title' => 'Archive Success', 'success_info' => 'Successfully archived file!']);
        }
    
        return redirect()->back()->withErrors(['failed_archive' => 'File not found']);
    }

    public function restoreFile(Request $request)
    {
        $fileName = $request->input('file');
        $filePath = storage_path('app/public/archive_folder/' . $fileName);
        $originalFileName = ArchiveFile::where('timestamped_name', $fileName)
                            ->pluck('original_name')
                            ->first();

        if (file_exists($filePath)) {
            $originalPath = storage_path('app/public/uploads/' . $originalFileName);

            // Check if file already exists
            if (file_exists($originalPath)) {
                // Append a number to the filename to make it unique
                $fileInfo = pathinfo($originalFileName);
                $baseName = $fileInfo['filename'];
                $extension = $fileInfo['extension'];
                $counter = 1;

                while (file_exists($originalPath)) {
                    $newFileName = $baseName . '(' . $counter . ').' . $extension;
                    $originalPath = storage_path('app/public/uploads/' . $newFileName);
                    $counter++;
                }
            }
            rename($filePath, $originalPath);

            // Delete record from database
            ArchiveFile::where('timestamped_name', $fileName)->delete();

            return redirect()->back()->with(['success_title' => 'Restore Success', 'success_info' => 'File restored successfully!']);
        }

        return redirect()->back()->withErrors(['failed_restore' => 'File not found']);
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

    public function showSystemFiles()
    {
        // Define the path to the external directory
        $directoryPath = base_path('../ThesisPredictiveModel/TrainingData');

        // Initialize an array to hold file information
        $data = [];

        // Check if the directory exists
        if (is_dir($directoryPath)) {
            // Scan the directory for files
            $files = array_diff(scandir($directoryPath), ['..', '.']); // Exclude '.' and '..'

            // Process each file
            foreach ($files as $file) {
                if (is_file($directoryPath . '/' . $file)) {
                    $data[] = ['file' => $file];
                }
            }
        } else {
            // Handle the case where the directory does not exist
            // You might want to log an error or provide a message to the user
            $data = ['error' => 'Directory does not exist.'];
        }

        // Return the view with the file data
        return view('systemfiles', compact('data'));
    }

    public function deleteSystemFile(Request $request)
    {
        $fileName = $request->input('file');

        // Define the path to the external directory
        $directoryPath = base_path('../ThesisPredictiveModel/TrainingData');
        
        // Check if the directory exists
        if (is_dir($directoryPath)) {
            // Path to the file
            $filePath = $directoryPath . "/" . $fileName;

            // Get all files in the directory
            $files = array_diff(scandir($directoryPath), ['..', '.']); // Exclude '.' and '..'

            // Check if there is only one file in the directory
            if (count($files) <= 1) {
                return redirect()->back()->withErrors(['failed_delete' => 'Cannot delete the file. Directory must have at least one file.']);
            }

            // Check if file exists and delete it
            if (File::exists($filePath)) {
                File::delete($filePath);
                return redirect()->back()->with(['success_title' => 'Delete Success', 'success_info' => 'File deleted successfully!']);
            }
        } else {
            return redirect()->back()->withErrors(['failed_delete' => 'Directory does not exist.']);
        }
        return redirect()->back()->withErrors(['failed_delete' => 'File not found.']);
    }

    public function uploadSystemFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Get the original filename
            $originalName = $file->getClientOriginalName();

            // Define the path to the external directory
            $directoryPath = base_path('../ThesisPredictiveModel/TrainingData');
            
            // Check if the directory exists
            if (!is_dir($directoryPath)) {
                return redirect()->back()->withErrors(['failed_upload' => 'Directory does not exist.']);
            }

            // Load the file using PhpSpreadsheet
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Define the required columns
            $requiredColumns = [
                'age', 'gender', 'algebra', 'trigo', 'advalgebra', 'anageo', 'diffcal', 'stats', 
                'intcal', 'advmat', 'numeric', 'vector', 'elxdevice', 'elxcirc', 'signals', 
                'princo', 'lcst', 'digicom', 'trans', 'micro', 'broadcast', 'control', 
                'circ1', 'elemag', 'circ2', 'passed'
            ];

            // Check if the required columns exist in the header row
            $header = array_map('strtolower', $data[0]); // Convert header to lowercase for case-insensitive comparison
            foreach ($requiredColumns as $column) {
                if (!in_array($column, $header)) {
                    return redirect()->back()->withErrors(['failed_upload' => "Missing required column: $column"]);
                }
            }

            // Check for missing data in the required columns
            $columnIndices = array_flip($header);
            foreach ($data as $rowIndex => $row) {
                if ($rowIndex == 0) continue; // Skip header row
                foreach ($requiredColumns as $column) {
                    if (!isset($row[$columnIndices[$column]]) || $row[$columnIndices[$column]] === '') {
                        return redirect()->back()->withErrors(['failed_upload' => "Missing data in column: $column at row: " . ($rowIndex + 1)]);
                    }
                }
            }

            // Move the file to the specified directory
            $file->move($directoryPath, $originalName);
            return redirect()->back()->with(['success_title' => 'Upload Success', 'success_info' => 'File uploaded successfully!']);
        }

        return redirect()->back()->withErrors(['failed_upload' => 'No file uploaded']);
    }

    public function downloadSystemFile(Request $request)
    {
        $fileName = $request->query('file');

        // Define the path to the external directory
        $directoryPath = base_path('../ThesisPredictiveModel/TrainingData');

        // Check if the directory exists
        if (!is_dir($directoryPath)) {
            return redirect()->back()->withErrors(['failed_download' => 'Directory does not exist.']);
        }

        // Path to the file
        $filePath = $directoryPath . '/' . $fileName;

        // Check if file exists and download
        if (File::exists($filePath)) {
            return response()->download($filePath);
        }

        return redirect()->back()->withErrors(['failed_download' => 'File not found.']);
    }

    public function reloadModel(Request $request)
    {
        // Define the path to the batch file
        $batchFilePath = base_path('../reload_model.bat');

        // Check if the batch file exists
        if (!file_exists($batchFilePath)) {
            return redirect()->back()->withErrors(['failed_reload' => 'Batch file does not exist.']);
        }

        // Execute the batch file
        $output = [];
        $returnVar = 0;
        exec("{$batchFilePath} 2>&1", $output, $returnVar);

        // Check the result
        if ($returnVar === 0) {
            return redirect()->back()->with(['success_title' => 'Model Reload Success', 'success_info' => 'Predictive model reloaded successfully!']);
        } else {
            // Capture and log the output for debugging
            Log::error('Model reload failed', ['output' => $output, 'return_var' => $returnVar]);
            return redirect()->back()->withErrors(['failed_reload' => 'Failed to reload the predictive model.']);
        }
    }

    public function showArchivedFiles()
    {
        $files = ArchiveFile::where('archived_at', '>=', now()->subDays(30))
            ->orderBy('archived_at', 'desc')
            ->get();

        return view('archive', ['data' => $files]);
    }

    public function deletePermanently(Request $request)
    {
        $fileName = $request->input('file');
        $filePath = storage_path('app/public/recently_deleted/' . $fileName);

        if (file_exists($filePath)) {
            unlink($filePath);

            // Delete record from database
            ArchiveFile::where('timestamped_name', $fileName)->delete();

            return redirect()->back()->with(['success_title' => 'Delete Success', 'success_info' => 'File permanently deleted!']);
        }

        return redirect()->back()->withErrors(['failed_delete' => 'File not found']);
    }
}
