<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Client\Response;
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

            // Replace with your actual Python service URL
            $predictionServiceUrl = 'http://127.0.0.1:5001/predict';

            $response = Http::attach(
                'image',
                file_get_contents($imageFile->getRealPath()),
                $imageFile->getClientOriginalName()
            )->post($predictionServiceUrl);

            if ($response->successful()) {
                $responseData = $response->json();
                
                $heatmapBase64 = trim($responseData['heatmap_image'] ?? '');
                
                // Store all necessary data in the session for the PDF report
                session([
                    'imagePath' => $imagePath,
                    'heatmap_image' => $heatmapBase64,
                    'predictionData' => [
                        'predicted_class' => $responseData['predicted_class'] ?? 'N/A',
                        'confidence' => $responseData['confidence'] ?? 0.0,
                    ]
                ]);

                $predictionData = [
                    'predicted_class' => $responseData['predicted_class'] ?? 'N/A',
                    'confidence' => $responseData['confidence'] ?? 0.0,
                ];

                $heatmapDataUrl = 'data:image/jpeg;base64,' . $heatmapBase64;

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

    // New method to download the PDF report
    public function downloadResultAsPdf()
    {
        // Retrieve all the necessary data from the session
        $imagePath = session('imagePath');
        $base64Image = session('heatmap_image');
        $prediction = session('predictionData');
        
        if (!$imagePath || !$base64Image || !$prediction) {
            return redirect()->back()->withErrors(['error' => 'No report data found. Please generate a prediction first.']);
        }

        // Create the heatmap data URL
        $heatmapDataUrl = 'data:image/jpeg;base64,' . $base64Image;

        // Load the view and pass the data
        $pdf = Pdf::loadView('report', [
            'prediction' => $prediction,
            'imagePath' => $imagePath,
            'heatmapDataUrl' => $heatmapDataUrl,
        ]);

        // Download the generated PDF with a custom filename
        return $pdf->download('dental_ai_report.pdf');
    }

}