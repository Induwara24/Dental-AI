<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AI Dental Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #17a2b8;
            margin: 0;
            font-size: 24px;
        }
        .content {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .section {
            width: 48%;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            font-size: 20px;
            color: #333;
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 5px;
        }
        .prediction-info p {
            margin: 5px 0;
        }
        .prediction-info strong {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>AI Dental Report</h1>
            <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>Diagnosis Results</h2>
                <div class="prediction-info">
                    <p><strong>Predicted Condition:</strong> {{ $prediction['predicted_class'] }}</p>
                    <p><strong>Confidence Score:</strong> {{ number_format($prediction['confidence'] * 100, 2) }}%</p>
                </div>
            </div>
            
            <div class="section">
                <h2>Original X-ray</h2>
                <img src="{{ asset('storage/' . $imagePath) }}" alt="Uploaded X-Ray">
            </div>
        </div>

        <div class="content">
            <div class="section">
                <h2>Grad-CAM Heatmap</h2>
                <img src="{{ $heatmapDataUrl }}" alt="Grad-CAM Heatmap">
                <p style="text-align: center; font-size: 12px; margin-top: 10px; color: #666;">
                    The heatmap highlights areas that influenced the AI's decision.
                </p>
            </div>

            <div class="section">
                <h2>Important Disclaimer</h2>
                <p style="color: #888;">
                    This AI diagnosis is for educational and research purposes only. Always consult with a qualified dental professional for medical advice and treatment decisions.
                </p>
            </div>
        </div>
    </div>
</body>
</html>