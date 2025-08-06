@extends('layouts.app')

@section('title', 'Diagnosis Results')

@section('content')
    <div class="container mx-auto mt-8 p-4">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Analysis Results</h1>
            <p class="text-gray-600">AI-powered diagnosis with visual explanations</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-1 bg-white p-6 rounded-lg custom-shadow h-full">
                <h2 class="text-xl font-semibold mb-4 text-gray-700"><i class="fas fa-check-circle text-green-500 mr-2"></i>Diagnosis Results</h2>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-gray-500">Predicted Condition</p>
                        <p class="text-2xl font-bold">{{ $prediction['predicted_class'] }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Confidence Score</p>
                        <p class="text-3xl font-bold text-green-500">{{ number_format($prediction['confidence'] * 100, 2) }}%</p>
                    </div>
                </div>

                <hr class="my-6">
                
                <div class="mb-6">
                    <div class="flex items-center space-x-2 text-blue-500 cursor-pointer hover:underline">
                        <i class="fas fa-eye"></i>
                        <span>Show Heatmap</span>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">The heatmap highlights areas that influenced the AI's decision using Grad-CAM visualization.</p>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('download.result.pdf') }}" class="btn btn-primary w-100">
                        <i class="fas fa-file-pdf me-2"></i> Download as PDF
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-upload me-2"></i> Upload Another Image
                    </a>
                </div>
                            </div>

            <div class="md:col-span-2 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-4 rounded-lg custom-shadow">
                        <h3 class="text-center text-xl font-semibold mb-4 text-gray-700">Original X-ray</h3>
                        <img src="{{ asset('storage/' . $imagePath) }}" alt="Uploaded X-Ray" class="w-full rounded-lg">
                    </div>
                    <div class="bg-white p-4 rounded-lg custom-shadow">
                        <h3 class="text-center text-xl font-semibold mb-4 text-gray-700">Grad-CAM Heatmap</h3>
                        <img src="{{ $heatmapDataUrl }}" alt="Grad-CAM Heatmap" class="w-full rounded-lg">
                        <p class="text-center text-sm text-gray-500 mt-2">Red areas indicate regions of highest AI attention</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg custom-shadow">
                    <h3 class="text-xl font-semibold mb-4 text-gray-700">Understanding Your Results</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600">
                        <div>
                            <h4 class="font-bold">Confidence Score</h4>
                            <p class="text-sm">Indicates how certain the AI model is about its prediction. Higher scores indicate greater confidence in the diagnosis.</p>
                        </div>
                        <div>
                            <h4 class="font-bold">Grad-CAM Heatmap</h4>
                            <p class="text-sm">Shows which areas of the X-ray the AI focused on when making its prediction. Warmer colors indicate higher attention.</p>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mt-6" role="alert">
                        <p class="font-bold"><i class="fas fa-exclamation-triangle mr-2"></i>Important Disclaimer</p>
                        <p class="text-sm">This AI diagnosis is for educational and research purposes only. Always consult with a qualified dental professional for medical advice and treatment decisions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection