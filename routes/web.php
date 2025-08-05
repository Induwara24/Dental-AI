<?php

use App\Http\Controllers\DentalAIController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [DentalAIController::class, 'index'])->name('home');
Route::post('/predict', [DentalAIController::class, 'predict'])->name('predict');