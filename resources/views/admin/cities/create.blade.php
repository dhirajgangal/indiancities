@extends('layouts.admin')

@section('title', isset($city) ? 'Edit City' : 'Add City')

@section('styles')
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
        margin-bottom: 15px;
    }

    .form-row.full {
        grid-template-columns: 1fr;
    }

    .form-row.three-cols {
        grid-template-columns: repeat(3, 1fr);
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
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #eee;
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
    <a href="{{ route('admin.cities.index') }}">
        <i class="fas fa-arrow-left"></i> Back to Cities
    </a>
</div>

<!-- Page Header -->
<div class="page-header">
    <h1>
        <i class="fas fa-plus-circle"></i>
        {{ isset($city) ? 'Edit City' : 'Add New City' }}
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
          action="{{ isset($city) ? route('admin.cities.update', $city) : route('admin.cities.store') }}" 
          enctype="multipart/form-data" 
          novalidate>
        @csrf
        @if(isset($city))
            @method('PUT')
        @endif

        <!-- City Name & Image -->
        <div class="form-row">
            <div class="form-group">
                <label for="name">
                    City Name
                    <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', isset($city) ? $city->name : '') }}"
                    placeholder="Enter city name"
                    required>
                @error('name')
                    <div class="error-text">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    City name (auto-generates slug)
                </div>
            </div>

            <div class="form-group">
                <label for="image">City Image</label>
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    accept="image/jpeg,image/png,image/gif,image/webp"
                    onchange="previewImage(this)">
                @error('image')
                    <div class="error-text">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    JPG, PNG, GIF (Max 2MB)
                </div>
                @if(isset($city) && $city->image)
                    <div class="image-preview-section">
                        <p>Current:</p>
                        <img src="{{ asset('storage/' . $city->image) }}" alt="{{ $city->name }}" class="img-preview">
                    </div>
                @endif
                <div id="imagePreview" class="image-preview-section" style="display: none;">
                    <p>Preview:</p>
                    <img id="previewImg" src="" alt="Preview" class="img-preview">
                </div>
            </div>
        </div>

        <!-- Description (Full Width) -->
        <div class="form-row full">
            <div class="form-group">
                <label for="description">
                    Description
                    <span class="required">*</span>
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    placeholder="Enter city description..."
                    required>{{ old('description', isset($city) ? $city->description : '') }}</textarea>
                @error('description')
                    <div class="error-text">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    Detailed information about the city
                </div>
            </div>
        </div>

        <!-- Slug -->
        <div class="form-row">
            <div class="form-group">
                <label for="slug">
                    Slug
                    <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="slug" 
                    name="slug" 
                    value="{{ old('slug', isset($city) ? $city->slug : '') }}"
                    placeholder="auto-generated"
                    readonly>
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    Auto-generated from name
                </div>
            </div>
        </div>

        <!-- Meta Fields (3 Columns) -->
        <div class="form-row three-cols">
            <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <input 
                    type="text" 
                    id="meta_title" 
                    name="meta_title" 
                    value="{{ old('meta_title', isset($city) ? $city->meta_title : '') }}"
                    placeholder="SEO title"
                    maxlength="60"
                    onkeyup="updateMetaCount(this, 'meta_title_count')">
                @error('meta_title')
                    <div class="error-text">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
                <div class="help-text">
                    <span id="meta_title_count">{{ old('meta_title', isset($city) ? strlen($city->meta_title) : 0) }}</span>/60
                </div>
            </div>

            <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <input 
                    type="text" 
                    id="meta_description" 
                    name="meta_description" 
                    value="{{ old('meta_description', isset($city) ? $city->meta_description : '') }}"
                    placeholder="SEO description"
                    maxlength="160"
                    onkeyup="updateMetaCount(this, 'meta_desc_count')">
                @error('meta_description')
                    <div class="error-text">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
                <div class="help-text">
                    <span id="meta_desc_count">{{ old('meta_description', isset($city) ? strlen($city->meta_description) : 0) }}</span>/160
                </div>
            </div>

            <div class="form-group">
                <label for="meta_keywords">Meta Keywords</label>
                <input 
                    type="text" 
                    id="meta_keywords" 
                    name="meta_keywords" 
                    value="{{ old('meta_keywords', isset($city) ? $city->meta_keywords : '') }}"
                    placeholder="Keywords (comma sep)"
                    maxlength="160"
                    onkeyup="updateMetaCount(this, 'meta_keywords_count')">
                @error('meta_keywords')
                    <div class="error-text">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
                <div class="help-text">
                    <span id="meta_keywords_count">{{ old('meta_keywords', isset($city) ? strlen($city->meta_keywords) : 0) }}</span>/160
                </div>
            </div>
        </div>

        <!-- Status & Homepage -->
        <div class="form-row">
            <div class="form-group">
                <label>&nbsp;</label>
                <div class="checkbox-group">
                    <input 
                        type="checkbox" 
                        id="status" 
                        name="status" 
                        value="1"
                        {{ old('status', isset($city) ? $city->status : true) ? 'checked' : '' }}>
                    <label for="status" style="margin-bottom: 0;">
                        <i class="fas fa-eye"></i> Active Status
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>&nbsp;</label>
                <div class="checkbox-group">
                    <input
                        type="checkbox"
                        id="visible_on_homepage"
                        name="visible_on_homepage"
                        value="1"
                        {{ old('visible_on_homepage', isset($city) ? $city->visible_on_homepage : false) ? 'checked' : '' }}>
                    <label for="visible_on_homepage" style="margin-bottom: 0;">
                        <i class="fas fa-home"></i> Homepage Visible
                    </label>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                {{ isset($city) ? 'Update City' : 'Create City' }}
            </button>
            <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Cancel
            </a>
        </div>
    </form>
</div>

<!-- Image Preview Script -->
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
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

    // Auto-generate slug from city name
    document.getElementById('name').addEventListener('keyup', function() {
        const slug = this.value
            .toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        document.getElementById('slug').value = slug;
    });

    // Update character count for meta fields
    function updateMetaCount(input, countElementId) {
        const countElement = document.getElementById(countElementId);
        if (countElement) {
            countElement.textContent = input.value.length;
        }
    }
</script>
@endsection