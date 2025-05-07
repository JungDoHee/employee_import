<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\FileUploadController;

Route::get('/', [FileUploadController::class, 'uploadIndex']);
Route::post('/fileImport', [FileUploadController::class, 'fileImport']);