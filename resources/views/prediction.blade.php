<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental AI Diagnosis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
            color: #2c3e50 !important;
        }
        .nav-link {
            font-weight: 500;
        }
        .hero-section {
            background-color: #e9ecef;
            padding: 8rem 0;
            text-align: center;
        }
        .hero-section h1 {
            font-weight: 700;
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
        }
        .hero-section p {
            font-size: 1.25rem;
            color: #6c757d;
            max-width: 700px;
            margin: 0 auto 2rem;
        }
        .icon-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .icon-card:hover {
            transform: translateY(-5px);
        }
        .icon-wrapper {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 1rem;
        }
        .btn-upload {
            background-color: #2c3e50;
            color: white;
            border: none;
        }
        .btn-upload:hover {
            background-color: #34495e;
            color: white;
        }
        .file-upload-input {
            display: none;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">Dental AI Diagnosis</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Team</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="container">
            <h1 class="display-4">Dental X-Ray Diagnosis with Explainable AI</h1>
            <p class="lead">
                Upload a dental X-ray image and receive a diagnosis with visual explanations powered by AI. Our advanced system provides accurate predictions with transparent, interpretable results.
            </p>
            
            <form action="{{ route('predict') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <input type="file" name="image" id="file-upload-input" class="file-upload-input" required>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <button type="button" id="upload-btn" class="btn btn-dark btn-lg px-4 gap-3 btn-upload">
                        <i class="bi bi-cloud-arrow-up-fill me-2"></i> Upload X-ray
                    </button>
                    <a href="#" class="btn btn-outline-secondary btn-lg px-4">Learn More</a>
                </div>
            </form>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-5">How It Works</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card icon-card p-4 h-100">
                    <div class="card-body text-center">
                        <div class="icon-wrapper">
                            <i class="bi bi-upload"></i>
                        </div>
                        <h4 class="card-title">1. Upload X-ray</h4>
                        <p class="card-text text-muted">Upload your dental X-ray image in JPG or PNG format</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card icon-card p-4 h-100">
                    <div class="card-body text-center">
                        <div class="icon-wrapper">
                            <i class="bi bi-robot"></i>
                        </div>
                        <h4 class="card-title">2. AI Analysis</h4>
                        <p class="card-text text-muted">Our AI model analyzes the image and predicts dental conditions</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card icon-card p-4 h-100">
                    <div class="card-body text-center">
                        <div class="icon-wrapper">
                            <i class="bi bi-eye"></i>
                        </div>
                        <h4 class="card-title">3. Visual Explanation</h4>
                        <p class="card-text text-muted">View results with Grad-CAM heatmap showing areas of focus</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($prediction))
    <div class="container my-5">
        <div class="card p-4 shadow-lg">
            <h2 class="text-center mb-4">Prediction Result</h2>
            <div class="row">
                <div class="col-md-6 text-center">
                    <h4>Predicted Class</h4>
                    <p class="lead">{{ $prediction['predicted_class'] }}</p>
                </div>
                <div class="col-md-6 text-center">
                    <h4>Confidence</h4>
                    <p class="lead">{{ number_format($prediction['confidence'] * 100, 2) }}%</p>
                </div>
            </div>
            @if(isset($prediction['heatmap_image']))
            <div class="mt-4 text-center">
                <h3>Model's Focus Area (Grad-CAM)</h3>
                <img src="data:image/jpeg;base64,{{ $prediction['heatmap_image'] }}" alt="Grad-CAM Heatmap" class="img-fluid rounded shadow-sm">
            </div>
            @endif
        </div>
    </div>
    @endif

    @if(isset($error))
    <div class="container mt-5">
        <div class="alert alert-danger text-center" role="alert">
            <h4 class="alert-heading">Error</h4>
            <p>{{ $error }}</p>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        document.getElementById('upload-btn').addEventListener('click', function() {
            document.getElementById('file-upload-input').click();
        });

        document.getElementById('file-upload-input').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                document.getElementById('uploadForm').submit();
            }
        });
    </script>
</body>
</html>