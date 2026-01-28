@extends('layouts.admin')

@section('title', 'Videos Management')

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