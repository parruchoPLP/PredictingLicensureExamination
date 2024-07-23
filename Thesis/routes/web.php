<?php

use Illuminate\Support\Facades\Route;
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
Route::post('/authenticate', [UserController::class, 'authenticate'])->name('authenticate');

Route::middleware(['auth'])->group(function () {
    Route::get('/report', [ReportController::class, 'showReport']);
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
    Route::get('/analytics', function () {
        return view('analytics');
    });
    Route::get('/', function () {
        return view('dashboard');
    });
    Route::get('/filemanagement', [FileController::class, 'showfiles']);
    Route::post('/upload', [FileController::class, 'upload'])->name('upload');
});