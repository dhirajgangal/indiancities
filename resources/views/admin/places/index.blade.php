@extends('layouts.admin')

@section('title', 'Places Management')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1>
        <i class="fas fa-map-marker-alt"></i> Manage Places
    </h1>
    <a href="{{ route('admin.places.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Add New Place
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
    <input type="text" name="search" placeholder="Search places..." value="{{ $search }}" style="flex:1;">
    
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
    <a href="{{ route('admin.places.index') }}" class="btn-primary" style="background: #6c757d;">Reset</a>
</form>

<!-- Table Container -->
<div class="table-container">
    @if($places->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>City</th>
                    <th>Published</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($places as $item)
                    <tr>
                        <td>
                            @if($item->image)                                
                                <img src="{{ strpos($item->image, 'http') !== false ?  $item->image : asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="img-thumbnail">
                            @else
                                <span style="color: #ccc;">No Image</span>
                            @endif
                        </td>
                        <td><strong>{{ Str::limit($item->title, 30) }}</strong></td>
                        <td>{{ $item->city->name }}</td>
                        <td>{{ $item->published_date?->format('M d, Y') ?? '-' }}</td>
                        <td>
                            <span class="status-badge {{ $item->status ? 'status-active' : 'status-inactive' }}">
                                {{ $item->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" onclick="window.location='{{ route('admin.places.edit', $item) }}';" class="btn-sm btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" action="{{ route('admin.places.destroy', $item) }}" style="display:inline;" data-confirm="Delete this place?">
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
        <div class="admin-pagination">
            {{ $places->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="no-data">
            <i class="fas fa-inbox"></i>
            <p>No places found. <a href="{{ route('admin.places.create') }}" style="color: #667eea;">Create one now</a></p>
        </div>
    @endif
</div>
@endsection