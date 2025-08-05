<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dental AI Prediction</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>

    <body class="bg-gray-100">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Dental X-Ray Analysis</h1>
            <form action="{{ route('predict') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Upload X-Ray Image</label>
                    <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full">
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Analyze</button>
            </form>

            @if(isset($prediction))
                <div class="mt-4">
                    <h2 class="text-xl font-semibold">Prediction Result</h2>
                    <p><strong>Prediction:</strong> {{ $prediction }}</p>
                    <p><strong>Confidence:</strong> {{ number_format($confidence, 2) }}%</p>
                    <div class="flex space-x-4">
                        <div>
                            <h3 class="text-lg font-medium">Uploaded Image</h3>
                            <img src="{{ asset('storage/' . $imagePath) }}" alt="Uploaded X-Ray" class="max-w-xs">
                        </div>
                        <div>
                            <h3 class="text-lg font-medium">Grad-CAM Heatmap</h3>
                            <img src="data:image/jpeg;base64,{{ $heatmap }}" alt="Grad-CAM Heatmap" class="max-w-xs">
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->has('error'))
                <p class="text-red-500 text-sm mt-4">{{ $errors->first('error') }}</p>
            @endif
        </div>
    </body>

</html>