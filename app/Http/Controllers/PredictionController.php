<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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

        try {
            $imageFile = $request->file('image');
            $imagePath = $imageFile->store('x-rays', 'public');

            // Replace this with the URL of your actual Python prediction service
            $predictionServiceUrl = 'http://127.0.0.1:5001/predict';

            // Send the image to the Python prediction service
            $response = Http::attach(
                'image',
                file_get_contents($imageFile->getRealPath()),
                $imageFile->getClientOriginalName()
            )->post($predictionServiceUrl);

            // Check if the request was successful
            if ($response->successful()) {
                // Decode the JSON response from the Python service
                $responseData = $response->json();

                // Retrieve the prediction and heatmap data from the response
                $predictionData = [
                    'predicted_class' => $responseData['predicted_class'] ?? 'N/A',
                    'confidence' => $responseData['confidence'] ?? 0.0,
                    // Remove any potential whitespace/newlines from the base64 string
                    'heatmap_image' => trim($responseData['heatmap_image'] ?? ''),
                ];

                // Create the full data URL in the controller to ensure it's clean
                $heatmapDataUrl = 'data:image/jpeg;base64,' . $predictionData['heatmap_image'];

                return view('dental-ai', [
                    'prediction' => $predictionData,
                    'imagePath' => $imagePath,
                    'heatmapDataUrl' => $heatmapDataUrl,
                ]);

            } else {
                return redirect()->back()->withErrors(['error' => 'Prediction service failed. Status: ' . $response->status()]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}