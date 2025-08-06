<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental AI Diagnosis - Results</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .custom-shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>
<body class="bg-gray-100">

    <header class="bg-white custom-shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="fas fa-tooth text-blue-500 text-2xl"></i>
                <a href="#" class="text-xl font-bold text-gray-800">Dental AI Diagnosis</a>
            </div>
            <nav>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-500 px-3 py-2 rounded-md font-medium">Home</a>
                <a href="#" class="text-gray-600 hover:text-blue-500 px-3 py-2 rounded-md font-medium">About</a>
                <a href="#" class="text-white bg-blue-500 hover:bg-blue-600 px-3 py-2 rounded-md font-medium">Upload</a>
                <a href="#" class="text-gray-600 hover:text-blue-500 px-3 py-2 rounded-md font-medium">Team</a>
            </nav>
        </div>
    </header>

    @if(isset($prediction))
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
                    <button class="w-full bg-blue-500 text-white py-2 rounded-lg font-medium hover:bg-blue-600 transition-colors">
                        <i class="fas fa-download mr-2"></i> Download Result
                    </button>
                    <a href="{{ route('home') }}" class="w-full block text-center bg-gray-200 text-gray-700 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                        <i class="fas fa-upload mr-2"></i> Upload Another Image
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
    @else
    <div class="container mx-auto mt-8 p-4">
        <div class="alert alert-danger text-center bg-white p-6 rounded-lg custom-shadow">
            <h4 class="text-xl font-semibold text-red-500">Error</h4>
            @if($errors->has('error'))
            <p class="text-gray-600">{{ $errors->first('error') }}</p>
            @endif
            <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Go Back
            </a>
        </div>
    </div>
    @endif

</body>
</html>