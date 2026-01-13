@extends('layouts.admin')

@section('title', 'Add Carousel Item')

@section('content')
<div class="page-header">
    <h1>Add Carousel Item</h1>
</div>
@section('styles')
<style>
    .form-card { background:#fff; padding:20px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.06); }
    .form-row { margin-bottom:12px; }
    .form-row label { display:block; font-weight:600; margin-bottom:6px; }
    .form-row input[type="text"], .form-row input[type="number"], .form-row input[type="url"], .form-row input[type="file"] { width:100%; padding:8px 10px; border:1px solid #ddd; border-radius:6px; }
    .img-preview { width:100%; height:220px; object-fit:cover; border-radius:6px; border:1px solid #eee; display:block; margin-top:8px; }
    .btn { padding: 10px 14px; border-radius: 6px; display: inline-block; text-decoration: none; font-weight: 600; border: none; cursor: pointer; }
    .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; }
    .btn-primary:hover { transform: translateY(-1px); }
    .btn-secondary { background: #ecf0f1; color: #333; }
</style>
@endsection

<div class="form-card" style="display:flex;gap:20px;align-items:flex-start;">
    <form method="POST" action="{{ route('admin.home_content.store') }}" enctype="multipart/form-data" style="flex:1;">
        @csrf
        <div class="form-row">
            <label>Image</label>
            <input type="file" name="image" accept="image/*" id="imageInput">
        </div>

        <div class="form-row">
            <label>Order</label>
            <input type="number" name="order" value="{{ old('order', 0) }}" />
        </div>

        <div class="form-row">
            <label style="font-weight:600;"><input type="checkbox" name="active" value="1" checked> Active</label>
        </div>

        <div style="margin-top:12px;">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.home_content.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

    <aside style="width:360px;">
        <div style="background:#fff;padding:12px;border-radius:8px;border:1px solid #eee;">
            <strong>Preview</strong>
            <div id="previewBox" style="margin-top:10px;position:relative;">
                <img id="imagePreview" class="img-preview" style="display:none;" alt="Preview" />
                <button id="previewDeleteBtn" type="button" style="display:none;position:absolute;top:8px;right:8px;background:rgba(0,0,0,0.6);border:none;color:#fff;border-radius:50%;width:28px;height:28px;cursor:pointer;">
                    &times;
                </button>
                <div id="previewPlaceholder" style="display:block;margin-top:8px;color:#666;">No image selected</div>
            </div>
        </div>
    </aside>
</div>

@section('scripts')
<script>
    const imageInput = document.getElementById('imageInput');
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('previewPlaceholder');
    const deleteBtn = document.getElementById('previewDeleteBtn');

    function showPreview(dataUrl){
        preview.src = dataUrl;
        preview.style.display = 'block';
        placeholder.style.display = 'none';
        deleteBtn.style.display = 'block';
    }

    function clearPreview(){
        preview.src = '';
        preview.style.display = 'none';
        placeholder.style.display = 'block';
        deleteBtn.style.display = 'none';
        if (imageInput) { imageInput.value = ''; }
    }

    imageInput?.addEventListener('change', function(){
        const file = this.files && this.files[0];
        if (!file){ clearPreview(); return; }
        const reader = new FileReader();
        reader.onload = function(ev){ showPreview(ev.target.result); };
        reader.readAsDataURL(file);
    });

    deleteBtn?.addEventListener('click', function(){
        clearPreview();
    });
</script>
@endsection
@endsection
