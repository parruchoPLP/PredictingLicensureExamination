<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function showReport(Request $request)
    {
        $filename = $request->query('file', 'No file selected'); 
        return view('report', ['filename' => $filename]);
    }
}
