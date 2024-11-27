<?php

use Illuminate\Foundation\Exceptions\ReportableHandler;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::get('/guestpage', function () {
    return view('guestpage');
})->name('guestpage');
Route::post('/authenticate', [UserController::class, 'authenticate'])->name('authenticate');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::post('/indivpredict', [ReportController::class, 'getPrediction'])->name('individual.predict');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('about');
    }
});

Route::middleware(['auth'])->group(function () {
    Route::get('/report', [ReportController::class, 'showReport'])->name('report.show');
    Route::get('/indivReport', [ReportController::class, 'indivReport'])->name('indivReport');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [ReportController::class, 'dashboard'])->name('dashboard');
    Route::get('/acctmanagement', function () {
        return view('acctmanagement');
    });
    Route::get('/filemanagement', [FileController::class, 'showfiles']);
    Route::post('/upload', [FileController::class, 'upload'])->name('upload');
    Route::delete('/archive-file', [FileController::class, 'archiveFile'])->name('archive.file');
    Route::get('/download-file', [FileController::class, 'downloadFile'])->name('download.file');
    Route::get('/download-systemfile', [FileController::class, 'downloadSystemFile'])->name('download.systemfile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/systemfiles', [FileController::class, 'showSystemFiles']);
    Route::delete('/delete-systemfile', [FileController::class, 'deleteSystemFile'])->name('delete.systemfile');
    Route::post('/uploadSystemFile', [FileController::class, 'uploadSystemFile'])->name('upload.systemfile');
    Route::post('/reloadmodel', [FileController::class, 'reloadModel'])->name('reload.model');
    Route::get('/archivedfiles', [FileController::class, 'showarchivedfiles']);
    Route::post('/restore-file', [FileController::class, 'restoreFile'])->name('restore.file');
    Route::delete('/delete-permanently', [FileController::class, 'deletePermanently'])->name('delete.permanently');
});