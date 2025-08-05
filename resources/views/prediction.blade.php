<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dental AI Prediction</title>
</head>

<body>
    <h1>Upload a dental X-ray for analysis</h1>
    <form action="{{ route('predict') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" required>
        <button type="submit">Predict</button>
    </form>

    @if(isset($prediction))
        <div>
            <h2>Prediction Result</h2>
            <p><strong>Predicted Class:</strong> {{ $prediction['predicted_class'] }}</p>
            <p><strong>Confidence:</strong> {{ number_format($prediction['confidence'] * 100, 2) }}%</p>
        </div>
    @endif

    @if(isset($error))
        <div style="color: red;">
            <h2>Error</h2>
            <p>{{ $error }}</p>
        </div>
    @endif
</body>

</html>