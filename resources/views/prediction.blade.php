@extends('layouts.app')

@section('title', 'Upload X-ray')

@section('content')
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

    <div id="loadingOverlay" class="loading-overlay" style="display:none;">
        <div class="loading-spinner"></div>
        <p class="mt-3">Analyzing X-ray, please wait...</p>
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
@endsection

@section('scripts')
    <script>
        document.getElementById('upload-btn').addEventListener('click', function() {
            document.getElementById('file-upload-input').click();
        });

        document.getElementById('file-upload-input').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                // Show the loading overlay
                document.getElementById('loadingOverlay').style.display = 'flex';
                // Submit the form
                document.getElementById('uploadForm').submit();
            }
        });
    </script>
    <style>
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 1050; /* A high z-index to be on top of everything */
    }
    .loading-spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
@endsection