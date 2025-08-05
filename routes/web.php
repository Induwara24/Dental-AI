<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictionController;

Route::get('/', [PredictionController::class, 'showForm'])->name('home');
Route::post('/predict', [PredictionController::class, 'predict'])->name('predict');