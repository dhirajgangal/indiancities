@extends('layouts.admin')

@section('title', 'Videos Management')

@section('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-header h1 {
        color: #333;
        font-size: 28px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px 25px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .search-bar {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .search-bar input, 
    .search-bar select {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }

    .search-bar button {
        padding: 10px 20px;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .search-bar button:hover {
        background: #764ba2;
    }

    .table-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    th {
        background: #f8f9fa;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e9ecef;
    }

    td {
        padding: 15px;
        border-bottom: 1px solid #e9ecef;
    }

    tr:hover {
        background: #f8f9fa;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-sm {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-edit {
        background: #e3f2fd;
        color: #1976d2;
    }

    .btn-delete {
        background: #ffebee;
        color: #c62828;
    }

    .youtube-link {
        color: #667eea;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .youtube-link:hover {
        color: #764ba2;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: #888;
    }

    .no-data i {
        font-size: 48px;
        margin-bottom: 20px;
        color: #ddd;
    }

    .pagination {
        padding: 20px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .search-bar {
            flex-direction: column;
        }

        .search-bar input,
        .search-bar select {
            width: 100%;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-sm {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1>
        <i class="fas fa-video"></i> Manage Videos
    </h1>
    <a href="{{ route('admin.videos.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Add New Video
    </a>
</div>

<!-- Success Alert -->
@if($message = session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ $message }}
    </div>
@endif

<!-- Search Bar -->
<form method="GET" class="search-bar">
    <input type="text" name="search" placeholder="Search videos..." value="{{ $search }}" style="flex:1;">
    
    <select name="city">
        <option value="">All Cities</option>
        @foreach($cities as $c)
            <option value="{{ $c->id }}" {{ $city == $c->id ? 'selected' : '' }}>
                {{ $c->name }}
            </option>
        @endforeach
    </select>

    <select name="per_page" onchange="this.form.submit()">
        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 per page</option>
        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 per page</option>
        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 per page</option>
    </select>

    <button type="submit"><i class="fas fa-search"></i> Search</button>
    <a href="{{ route('admin.videos.index') }}" class="btn-primary" style="background: #6c757d;">Reset</a>
</form>

<!-- Table Container -->
<div class="table-container">
    @if($videos->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>City</th>
                    <th>YouTube URL</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($videos as $video)
                    <tr>
                        <td><strong>{{ Str::limit($video->title, 30) }}</strong></td>
                        <td>{{ $video->city->name }}</td>
                        <td>
                            <a href="{{ $video->youtube_url }}" target="_blank" class="youtube-link">
                                <i class="fab fa-youtube"></i> Watch
                            </a>
                        </td>
                        <td>
                            <span class="status-badge {{ $video->status ? 'status-active' : 'status-inactive' }}">
                                {{ $video->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $video->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" onclick="window.location='{{ route('admin.videos.edit', $video) }}';" class="btn-sm btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" action="{{ route('admin.videos.destroy', $video) }}" style="display:inline;" data-confirm="Delete this video?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-sm btn-delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            {{ $videos->links() }}
        </div>
    @else
        <div class="no-data">
            <i class="fas fa-inbox"></i>
            <p>No videos found. <a href="{{ route('admin.videos.create') }}" style="color: #667eea;">Create one now</a></p>
        </div>
    @endif
</div>
@endsection