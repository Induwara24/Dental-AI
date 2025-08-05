<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PredictionController extends Controller
{
    public function showForm()
    {
        return view('prediction');
    }

    public function predict(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageFile = $request->file('image');

        try {
            // Send the image to the Python prediction service
            $response = Http::attach(
                'image',
                file_get_contents($imageFile->getRealPath()),
                $imageFile->getClientOriginalName()
            )->post('http://127.0.0.1:5001/predict'); // Make sure this URL is correct

            if ($response->successful()) {
                $prediction = $response->json();
                return view('prediction', ['prediction' => $prediction]);
            } else {
                return view('prediction', ['error' => 'Prediction service returned an error.']);
            }
        } catch (\Exception $e) {
            return view('prediction', ['error' => 'Could not connect to the prediction service.']);
        }
    }
}