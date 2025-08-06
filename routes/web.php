<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictionController;

Route::get('/', [PredictionController::class, 'showForm'])->name('home');
Route::post('/predict', [PredictionController::class, 'predict'])->name('predict');
Route::get('/download-result', [PredictionController::class, 'downloadResult'])->name('download.result');
Route::get('/download-result', [PredictionController::class, 'downloadResultAsPdf'])->name('download.result.pdf');