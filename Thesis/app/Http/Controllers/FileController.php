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
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $relativePath = 'public/uploads/' . $originalName;

            if (Storage::exists($relativePath)) {
                return back()->withErrors(['failed_upload' => 'A file with the same name already exists.']);
            }

            $file->storeAs('public/uploads', $originalName);
            $fullPath = storage_path('app/' . $relativePath);

            // Send the file to Flask for processing
            $response = Http::attach(
                'file', file_get_contents($file->getPathname()), $originalName
            )->post('http://localhost:5000/batchpredict');

            if ($response->successful()) {
                $csvContent = $response->body();
    
                // Overwrite the uploaded CSV file with the processed data
                Storage::disk('local')->put($relativePath, $csvContent);
    
                return back()->with(['success_title' => 'Success', 'success_info' => 'File uploaded and processed successfully']);
            } else {
                Storage::delete($relativePath);
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
        $headers = !empty($data[0]) ? array_map('trim', array_keys($data[0][0])) : [];

        return view('report', [
            'data' => $data,
            'headers' => $headers,
            'filename' => $filename
        ]);
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
        // Define the path within storage/app/public
        $directoryPath = 'public/TrainingData';
    
        // Initialize an array to hold file information
        $data = [];
    
        // Check if the directory exists and scan for files
        if (Storage::exists($directoryPath)) {
            // Retrieve the files in the directory
            $files = Storage::files($directoryPath);
            $fileNames = array_map(fn($file) => basename($file), $files);
    
            // Send the file list to the Flask side for comparison
            $flaskUrl = 'http://localhost:5000/check-missing-files';
            $downloadUrl = 'http://localhost:5000/download/';
            
            $response = Http::post($flaskUrl, ['current_files' => $fileNames]);
    
            // Check if the response contains any missing files
            if ($response->ok() && isset($response['missing_files'])) {
                foreach ($response['missing_files'] as $missingFile) {
                    // Download each missing file from Flask and store it in storage/app/public/TrainingData
                    $fileResponse = Http::get($downloadUrl . $missingFile);
                    
                    if ($fileResponse->ok()) {
                        Storage::put($directoryPath . '/' . $missingFile, $fileResponse->body());
                        $data[] = ['file' => $missingFile]; // Add to the data array
                    }
                }
            }
    
            // Add existing files to the data array
            foreach ($fileNames as $file) {
                $data[] = ['file' => $file];
            }
    
        } else {
            $data = [['error' => 'Directory does not exist.']]; // Enforce array structure
        }
    
        // Ensure data is always treated as an array
        if (!is_array($data)) {
            $data = [$data];
        }
    
        // Return the view with the file data
        return view('systemfiles', compact('data'));
    }

    public function deleteSystemFile(Request $request)
    {
        $fileName = $request->input('file');

        // Define the path within storage/app/public
        $directoryPath = 'public/TrainingData';
        
        // Check if the directory exists
        if (Storage::exists($directoryPath)) {
            // Path to the file
            $filePath = $directoryPath . "/" . $fileName;

            // Get all files in the directory
            $files = Storage::files($directoryPath);

            // Check if there is only one file in the directory
            if (count($files) <= 1) {
                return redirect()->back()->withErrors(['failed_delete' => 'Cannot delete the file. Directory must have at least one file.']);
            }

            // Check if file exists locally
            if (Storage::exists($filePath)) {
                // Send delete request to Flask
                $flaskUrl = 'http://localhost:5000/delete-file';
                $response = Http::post($flaskUrl, ['file_name' => $fileName]);

                // Check if Flask deleted the file successfully
                if ($response->ok() && $response->json('status') === 'success') {
                    // Delete the file locally
                    Storage::delete($filePath);
                    return redirect()->back()->with(['success_title' => 'Delete Success', 'success_info' => 'File deleted successfully!']);
                } else {
                    return redirect()->back()->withErrors(['failed_delete' => 'Failed to delete file on Flask server.']);
                }
            }
        } else {
            return redirect()->back()->withErrors(['failed_delete' => 'Directory does not exist.']);
        }
        return redirect()->back()->withErrors(['failed_delete' => 'File not found.']);
    }

    public function uploadSystemFile(Request $request)
    {
        // Validate the file type
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Get the original filename
            $originalName = $file->getClientOriginalName();

            // Load the file using PhpSpreadsheet to check for required columns and missing data
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Define the required columns
            $requiredColumns = [
                'ECE 111', 'ECE 112', 'ECE 114', 'ECE 121', 'ECE 122', 'ECE 131', 
                'ECE 132', 'ECE 133', 'ECE 141', 'ECE 143', 'ECE 142', 'ECE 146', 
                'ECE 152', 'ECE 153', 'ECE 156', 'ECE 151', 'ECE 154', 'ECE 158', 
                'ECE 155', 'ECE 162', 'ECE 160', 'ECE 163', 'ECE 164', 'ECE 166', 
                'ECE 167', 'ECE 168', 'ECE 202', 'PERFORMANCE'
            ];

            // Check if the required columns exist in the header row
            $header = array_map('strtoupper', $data[0]); // Convert header to uppercase for case-insensitive comparison
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

            // Define the Flask server URL
            $flaskUrl = 'http://localhost:5000/upload-file';

            // Send the file to Flask as a multipart form-data request
            $response = Http::attach(
                'file', file_get_contents($file->getPathname()), $originalName
            )->post($flaskUrl);

            // Check the response from Flask
            if ($response->ok()) {
                return redirect()->back()->with(['success_title' => 'Upload Success', 'success_info' => 'File uploaded successfully!']);
            } else {
                $errorMessage = $response->json('message') ?? 'Failed to upload file to Flask';
                return redirect()->back()->withErrors(['failed_upload' => $errorMessage]);
            }
        }

        return redirect()->back()->withErrors(['failed_upload' => 'No file uploaded']);
    }

    public function downloadSystemFile(Request $request)
    {
        $fileName = $request->query('file');

        // Path to the file relative to the 'public' disk
        $filePath = 'TrainingData/' . $fileName;

        // Check if the file exists on the 'public' disk
        if (Storage::disk('public')->exists($filePath)) {
            /** @var \Illuminate\Filesystem\FilesystemAdapter */
            $fileSystem = Storage::disk('public');
            return $fileSystem->download($filePath);
        }

        return redirect()->back()->withErrors(['failed_download' => 'File not found.']);
    }

    public function reloadModel(Request $request)
    {
        // Define the Flask endpoint URL
        $flaskUrl = 'http://localhost:5000/reload-model';

        try {
            // Make a POST request to the Flask endpoint
            $response = Http::post($flaskUrl);

            // Check if the request was successful
            if ($response->successful()) {
                return redirect()->back()->with(['success_title' => 'Model Reload Success', 'success_info' => 'Predictive model reloaded successfully!']);
            } else {
                // Log the error for further debugging
                Log::error('Model reload failed', ['response' => $response->body()]);
                return redirect()->back()->withErrors(['failed_reload' => 'Failed to reload the predictive model.']);
            }
        } catch (\Exception $e) {
            // Capture and log any exceptions that occur
            Log::error('Exception while reloading model', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['failed_reload' => 'An error occurred while trying to reload the predictive model.']);
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
        $filePath = storage_path('app/public/archive_folder/' . $fileName);

        if (file_exists($filePath)) {
            unlink($filePath);

            // Delete record from database
            ArchiveFile::where('timestamped_name', $fileName)->delete();

            return redirect()->back()->with(['success_title' => 'Delete Success', 'success_info' => 'File permanently deleted!']);
        }

        return redirect()->back()->withErrors(['failed_delete' => 'File not found']);
    }
}
