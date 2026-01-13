@extends('layouts.admin')

@section('title', 'Add News')

@section('styles')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .breadcrumb {
        margin-bottom: 20px;
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
        margin-bottom: 20px;
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
        padding: 30px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 22px;
        position: relative;
    }

    .form-row.full {
        grid-template-columns: 1fr;
        margin-bottom: 48px;
        position: relative;
    }

    .form-row.three-cols {
        grid-template-columns: repeat(3, 1fr);
        margin-bottom: 22px;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        color: #333;
        font-weight: 600;
        font-size: 13px;
    }

    .form-group label .required {
        color: #e74c3c;
        margin-left: 2px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 13px;
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

    .help-text {
        font-size: 11px;
        color: #999;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .image-preview-section {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #eee;
    }

    .image-preview-section p {
        font-size: 11px;
        color: #666;
        margin-bottom: 8px;
    }

    .img-preview {
        width: 120px;
        height: 120px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #ddd;
        display: block;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        background: #f9f9f9;
        border-radius: 6px;
        border: 1px solid #ddd;
        margin-top: 6px;
    }

    .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #667eea;
    }

    .checkbox-group label {
        margin-bottom: 0;
        cursor: pointer;
        font-weight: 500;
        color: #333;
        font-size: 13px;
    }

    .error-text {
        color: #e74c3c;
        font-size: 11px;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
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
        margin: 8px 0 0 0;
        padding-left: 20px;
    }

    .alert li {
        margin: 3px 0;
        font-size: 13px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 38px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        clear: both;
    }

    .btn {
        padding: 10px 24px;
        border-radius: 6px;
        font-size: 13px;
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

    /* Quill Editor Styles */
    .ql-toolbar,
    .ql-container {
        display: block;
        width: 100%;
        box-sizing: border-box;
    }

    .ql-toolbar {
        border: 1px solid #ddd;
        border-radius: 6px 6px 0 0;
        background: #f9f9f9;
    }

    .ql-container {
        border: 1px solid #ddd;
        border-top: none;
        border-radius: 0 0 6px 6px;
        font-size: 13px;
        background: white;
        max-height: 380px;
        overflow-y: auto;
        position: relative;
        z-index: 0;
    }

    .form-group .ql-toolbar {
        margin-bottom: 0;
    }

    /* Ensure editor container occupies normal flow and has a sensible min height */
    #editor-container {
        min-height: 220px;
        margin-bottom: 8px;
        box-sizing: border-box;
        position: relative;
        z-index: 0;
    }

    /* ensure next form rows start below editor in case of layout quirks */
    .form-row.full + .form-row {
        clear: both;
    }

    /* hide underlying textarea used for submission */
    .form-group #description {
        display: none;
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .form-row.three-cols {
            grid-template-columns: 1fr;
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
    <a href="{{ route('admin.news.index') }}">
        <i class="fas fa-arrow-left"></i> Back to News
    </a>
</div>

<!-- Page Header -->
<div class="page-header">
    <h1>
        <i class="fas fa-plus-circle"></i>
        Add New News
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
          action="{{ route('admin.news.store') }}" 
          enctype="multipart/form-data" 
          id="newsForm"
          novalidate>
    <form method="POST" 
          action="{{ route('admin.news.store') }}" 
          enctype="multipart/form-data" 
          id="newsForm"
          novalidate>
        @csrf

        <!-- City & Featured Image -->
        <div class="form-row">
            <div class="form-group">
                <label for="city_id">
                    Select City
                    <span class="required">*</span>
                </label>
                <select id="city_id" name="city_id" required>
                    <option value="">-- Choose a City --</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
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
                    Select the city this news belongs to
                </div>
            </div>

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
                    JPG, PNG, GIF, WebP (Max 2MB)
                </div>
                <div id="imagePreview" class="image-preview-section" style="display: none;">
                    <p>Preview:</p>
                    <img id="previewImg" src="" alt="Preview" class="img-preview">
                </div>
            </div>
        </div>

        <!-- News Title (Full Width) -->
        <div class="form-row full">
            <div class="form-group">
                <label for="title">
                    News Title
                    <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}"
                    placeholder="Enter an attractive news headline"
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
        </div>

        <!-- News Description with Quill Editor (Full Width) -->
        <div class="form-row full">
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
                    required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-text">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    Provide comprehensive details about the news
                </div>
            </div>
        </div>

        <!-- Published Date & Status -->
        <div class="form-row">
            <div class="form-group" style="clear: both; margin-top:60px;">
                <label for="published_date">
                    Published Date
                </label>
                <input 
                    type="date" 
                    id="published_date" 
                    name="published_date"
                    value="{{ old('published_date') }}">
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

            <div class="form-group" style="clear: both; margin-top:60px;">
                <label>Status</label>
                <div class="checkbox-group">
                    <input 
                        type="checkbox" 
                        id="status" 
                        name="status" 
                        value="1"
                        {{ old('status', true) ? 'checked' : '' }}>
                    <label for="status">
                        <i class="fas fa-eye"></i>
                        Publish this news
                    </label>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-save"></i>
                Create News
            </button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
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

    // Load existing content if editing
    var existingContent = document.getElementById('description').value;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    // Update hidden textarea before form submission
    document.getElementById('newsForm').onsubmit = function(e) {
        var description = document.getElementById('description');
        description.value = quill.root.innerHTML;
        
        // Validate that description is not empty
        if (quill.getText().trim().length === 0) {
            alert('Please enter a description for the news.');
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
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection