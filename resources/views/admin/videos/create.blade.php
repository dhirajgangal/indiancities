@extends('layouts.admin')

@section('title', isset($video) ? 'Edit Video' : 'Add Video')

@section('styles')
<style>
    .breadcrumb {
        margin-bottom: 30px;
    }

    .breadcrumb a {
        color: #667eea;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 14px;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        color: #333;
        font-size: 28px;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .form-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 40px;
        max-width: 800px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: 600;
        font-size: 14px;
    }

    .form-group label .required {
        color: #e74c3c;
        margin-left: 2px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s ease;
        background: #f9f9f9;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group select {
        cursor: pointer;
        appearance: none;
        padding-right: 35px;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 20px;
    }

    .help-text {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .video-preview-section {
        margin-top: 15px;
        padding: 15px;
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 6px;
        display: none;
    }

    .video-preview-section.show {
        display: block;
    }

    .video-preview-section p {
        font-size: 12px;
        color: #666;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .video-embed {
        position: relative;
        width: 100%;
        height: 0;
        padding-bottom: 56.25%;
        overflow: hidden;
        border-radius: 6px;
    }

    .video-embed iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 6px;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
        background: #f9f9f9;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .checkbox-group input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #667eea;
    }

    .checkbox-group label {
        margin-bottom: 0;
        cursor: pointer;
        font-weight: 500;
        color: #333;
    }

    .error-text {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .alert-error {
        background: #fadbd8;
        color: #c0392b;
        border: 1px solid #f5b7b1;
    }

    .alert ul {
        margin: 10px 0 0 0;
        padding-left: 20px;
    }

    .alert li {
        margin: 5px 0;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 35px;
        padding-top: 25px;
        border-top: 2px solid #eee;
    }

    .btn {
        padding: 12px 30px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background: #ecf0f1;
        color: #333;
        border: 1px solid #ddd;
    }

    .btn-secondary:hover {
        background: #d5dbdb;
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 25px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="{{ route('admin.videos.index') }}">
        <i class="fas fa-arrow-left"></i> Back to Videos
    </a>
</div>

<!-- Page Header -->
<div class="page-header">
    <h1>
        <i class="fas fa-plus-circle"></i>
        {{ isset($video) ? 'Edit Video' : 'Add New Video' }}
    </h1>
</div>

<!-- Error Alert -->
@if ($errors->any())
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<!-- Form Card -->
<div class="form-card">
    <form method="POST" 
          action="{{ isset($video) ? route('admin.videos.update', $video) : route('admin.videos.store') }}" 
          novalidate>
        @csrf
        @if(isset($video))
            @method('PUT')
        @endif

        <!-- City Selection -->
        <div class="form-group">
            <label for="city_id">
                Select City
                <span class="required">*</span>
            </label>
            <select id="city_id" name="city_id" required>
                <option value="">-- Choose a City --</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" 
                        {{ old('city_id', isset($video) ? $video->city_id : '') == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
            @error('city_id')
                <div class="error-text">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
            <div class="help-text">
                <i class="fas fa-info-circle"></i>
                Select the city this video belongs to
            </div>
        </div>

        <!-- Video Title -->
        <div class="form-group">
            <label for="title">
                Video Title
                <span class="required">*</span>
            </label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                value="{{ old('title', isset($video) ? $video->title : '') }}"
                placeholder="Enter video title"
                required>
            @error('title')
                <div class="error-text">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
            <div class="help-text">
                <i class="fas fa-info-circle"></i>
                Enter an appropriate title for the video
            </div>
        </div>

        <!-- YouTube URL -->
        <div class="form-group">
            <label for="youtube_url">
                YouTube URL
                <span class="required">*</span>
            </label>
            <input 
                type="url" 
                id="youtube_url" 
                name="youtube_url" 
                value="{{ old('youtube_url', isset($video) ? $video->youtube_url : '') }}"
                placeholder="https://www.youtube.com/watch?v=..."
                onchange="updateVideoPreview()"
                required>
            @error('youtube_url')
                <div class="error-text">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
            <div class="help-text">
                <i class="fas fa-info-circle"></i>
                Paste the full YouTube video URL
            </div>
        </div>

        <!-- Video Preview -->
        <div id="videoPreview" class="video-preview-section">
            <p><i class="fas fa-play-circle"></i> Video Preview:</p>
            <div class="video-embed">
                <iframe id="previewEmbed" src="" allowfullscreen=""></iframe>
            </div>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">
                Description
            </label>
            <textarea 
                id="description" 
                name="description" 
                placeholder="Enter video description (optional)">{{ old('description', isset($video) ? $video->description : '') }}</textarea>
            @error('description')
                <div class="error-text">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
            <div class="help-text">
                <i class="fas fa-info-circle"></i>
                Add details about the video content
            </div>
        </div>

        <!-- Status Checkbox -->
        <div class="form-group">
            <div class="checkbox-group">
                <input 
                    type="checkbox" 
                    id="status" 
                    name="status" 
                    value="1"
                    {{ old('status', isset($video) ? $video->status : true) ? 'checked' : '' }}>
                <label for="status">
                    <i class="fas fa-eye"></i>
                    Publish this video (Make it visible to users)
                </label>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                {{ isset($video) ? 'Update Video' : 'Create Video' }}
            </button>
            <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Cancel
            </a>
        </div>
    </form>
</div>

<!-- YouTube URL Preview Script -->
<script>
    function updateVideoPreview() {
        const youtubeUrl = document.getElementById('youtube_url').value;
        const videoPreview = document.getElementById('videoPreview');
        const previewEmbed = document.getElementById('previewEmbed');

        if (!youtubeUrl) {
            videoPreview.classList.remove('show');
            return;
        }

        // Extract video ID from various YouTube URL formats
        let videoId = null;

        // Format: https://www.youtube.com/watch?v=VIDEO_ID
        if (youtubeUrl.includes('watch?v=')) {
            videoId = youtubeUrl.split('watch?v=')[1].split('&')[0];
        }
        // Format: https://youtu.be/VIDEO_ID
        else if (youtubeUrl.includes('youtu.be/')) {
            videoId = youtubeUrl.split('youtu.be/')[1].split('?')[0];
        }
        // Format: https://www.youtube.com/embed/VIDEO_ID
        else if (youtubeUrl.includes('/embed/')) {
            videoId = youtubeUrl.split('/embed/')[1].split('?')[0];
        }

        if (videoId) {
            const embedUrl = `https://www.youtube.com/embed/${videoId}`;
            previewEmbed.src = embedUrl;
            videoPreview.classList.add('show');
        } else {
            videoPreview.classList.remove('show');
        }
    }

    // Run preview on page load if URL already exists
    document.addEventListener('DOMContentLoaded', function() {
        const youtubeUrl = document.getElementById('youtube_url').value;
        if (youtubeUrl) {
            updateVideoPreview();
        }
    });
</script>
@endsection