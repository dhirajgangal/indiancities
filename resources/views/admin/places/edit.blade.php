@extends('layouts.admin')

@section('title', 'Edit Place')

@section('styles')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<!-- Custom Place Form CSS -->
<link href="{{ asset('css/admin/news-form.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb">
    <a href="{{ route('admin.places.index') }}">
        <i class="fas fa-arrow-left"></i> Back to Places List
    </a>
</div>

<!-- Page Header -->
<div class="page-header">
    <h1>
        <i class="fas fa-edit"></i>
        Edit Place
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
          action="{{ route('admin.places.update', $place) }}" 
          enctype="multipart/form-data" 
          id="placesForm"
          novalidate>
        @csrf
        @method('PUT')

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
                        {{ old('city_id', $place->city_id) == $city->id ? 'selected' : '' }}>
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
                Select the city this place belongs to
            </div>
        </div>

        <!-- Place Title -->
        <div class="form-group">
            <label for="title">
                Place Title
                <span class="required">*</span>
            </label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                value="{{ old('title', $place->title) }}"
                placeholder="Enter an attractive place title"
                required>
            @error('title')
                <div class="error-text">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
            <div class="help-text">
                <i class="fas fa-info-circle"></i>
                Make it catchy and informative
            </div>
        </div>

        <!-- Place Description with Quill Editor -->
        <div class="form-group">
            <label for="description">
                Description
                <span class="required">*</span>
            </label>
            <!-- Quill Editor Container -->
            <div id="editor-container"></div>
            <!-- Hidden textarea for form submission -->
            <textarea 
                id="description" 
                name="description" 
                required>{{ old('description', $place->description) }}</textarea>
            @error('description')
                <div class="error-text">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
            <div class="help-text">
                <i class="fas fa-info-circle"></i>
                Provide comprehensive details about the place. You can add images by clicking the image icon in the toolbar.
            </div>
        </div>

        <!-- Featured Image -->
        <div class="form-group">
            <label for="image">
                Featured Image
            </label>
            <input 
                type="file" 
                id="image" 
                name="image" 
                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                onchange="previewImage(this)">
            @error('image')
                <div class="error-text">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
            <div class="help-text">
                <i class="fas fa-info-circle"></i>
                Accepted: JPG, PNG, GIF, WebP (Max 2MB). Leave empty to keep current image.
            </div>
            @if($place->image)
                <div class="image-preview-section">
                    <p>Current image:</p>
                    <img src="{{ asset('storage/' . $place->image) }}" alt="{{ $place->title }}" class="img-preview" id="currentImage">
                </div>
            @endif
            <div id="imagePreview" class="image-preview-section" style="display: none;">
                <p>New Image Preview:</p>
                <img id="previewImg" src="" alt="Preview" class="img-preview">
            </div>
        </div>

        <!-- Published Date -->
        <div class="form-group">
            <label for="published_date">
                Published Date
            </label>
            <input 
                type="date" 
                id="published_date" 
                name="published_date"
                value="{{ old('published_date', $place->published_date ? $place->published_date->format('Y-m-d') : '') }}">
            @error('published_date')
                <div class="error-text">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $message }}
                </div>
            @enderror
            <div class="help-text">
                <i class="fas fa-info-circle"></i>
                Leave empty for current date
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
                    {{ old('status', $place->status) ? 'checked' : '' }}>
                <label for="status">
                    <i class="fas fa-eye"></i>
                    Publish this place (Make it visible to users)
                </label>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-save"></i>
                Update Place
            </button>
            <a href="{{ route('admin.places.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Initialize Quill Editor -->
<script>
    // Initialize Quill with custom toolbar
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: 'Enter detailed news description...',
        modules: {
            toolbar: [
                // Text formatting
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                
                // Font styling
                ['bold', 'italic', 'underline', 'strike'],
                
                // Text color and background
                [{ 'color': [] }, { 'background': [] }],
                
                // Lists
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                
                // Text alignment
                [{ 'align': [] }],
                
                // Links and Images
                ['link', 'image'],
                
                // Clear formatting
                ['clean']
            ]
        }
    });

    // Load existing content
    var existingContent = document.getElementById('description').value;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    // Update hidden textarea before form submission
    document.getElementById('placesForm').onsubmit = function(e) {
        var description = document.getElementById('description');
        description.value = quill.root.innerHTML;
        
        // Validate that description is not empty
        if (quill.getText().trim().length === 0) {
            alert('Please enter a description for the place.');
            e.preventDefault();
            return false;
        }

        // Show loading state
        var submitBtn = document.getElementById('submitBtn');
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
    };

    // Image Preview Function
    function previewImage(input) {
        if (input.files && input.files[0]) {
            // Check file size (2MB = 2097152 bytes)
            if (input.files[0].size > 2097152) {
                alert('File size must be less than 2MB');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('imagePreview');
                const previewImg = document.getElementById('previewImg');
                previewImg.src = e.target.result;
                preview.style.display = 'block';
                
                // Hide current image when new image is selected
                const currentImage = document.getElementById('currentImage');
                if (currentImage) {
                    currentImage.parentElement.style.display = 'none';
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection