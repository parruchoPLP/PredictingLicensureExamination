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

        // Search by ID if not null or an empty string
        if ($request->has('id') && $request->query('id') !== null && $request->query('id') !== '') {
            $collection = $collection->where('id', $request->query('id'));
        }

        // Paginate the filtered data
        $perPage = 15; // Number of items per page
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $filteredData = $collection->forPage($currentPage, $perPage);
        $paginator = new LengthAwarePaginator($filteredData, $collection->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('report', compact('paginator', 'headers', 'filename'));
    }
}
