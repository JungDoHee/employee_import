<?php

use Illuminate\Support\Facades\Route;
// use app\Http\Controllers\Employee\FileUploadController;

// Route::get('/', function () {
//     return view('test_tail');
// });

// Route::get('/', [Controller::class, 'index']);

use App\Http\Controllers\Employee\FileUploadController;

Route::get('/', [FileUploadController::class, 'uploadIndex']);
Route::post('/fileImport', [FileUploadController::class, 'fileImport']);