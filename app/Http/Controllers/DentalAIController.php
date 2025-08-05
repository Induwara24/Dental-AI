<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DentalAIController extends Controller
{
    public function index()
    {
        return view('dental-ai');
    }

    public function predict(Request $request)
    {
        // Validate the uploaded image
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // Store the image
        $imagePath = $request->file('image')->store('images', 'public');

        // Send the image to the Python API
        $response = Http::attach(
            'image',
            file_get_contents(storage_path('app/public/' . $imagePath)),
            $request->file('image')->getClientOriginalName()
        )->post('http://python-api-url/predict'); // Replace with your Python API URL

        // Check if the API request was successful
        if ($response->successful()) {
            $result = $response->json();
            return view('dental-ai', [
                'prediction' => $result['prediction'],
                'confidence' => $result['confidence'],
                'heatmap' => $result['heatmap'], // Base64 encoded heatmap image
                'imagePath' => $imagePath
            ]);
        } else {
            return back()->withErrors(['error' => 'Failed to get prediction from the model.']);
        }
    }
}
