@extends('layouts.admin')

@section('title', 'Cities Management')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1>
        <i class="fas fa-building"></i> Manage Cities
    </h1>
    <a href="{{ route('admin.cities.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Add New City
    </a>
</div>
<script>
    (function(){
        const token = '{{ csrf_token() }}';

        async function toggleRequest(url, value) {
            const res = await fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ value: value ? 1 : 0 })
            });
            return res.json();
        }

        function wireToggles() {
            document.querySelectorAll('.toggle-checkbox').forEach(cb => {
                cb.addEventListener('change', async function(e){
                    const url = this.dataset.url;
                    const value = this.checked;
                    const statusText = this.parentElement.querySelector('.status-text');
                    this.disabled = true;
                    try {
                        const data = await toggleRequest(url, value);
                        if (data.success) {
                            if (data.status !== undefined) {
                                statusText.textContent = data.status ? 'Active' : 'Inactive';
                            } else if (data.visible_on_homepage !== undefined) {
                                statusText.textContent = data.visible_on_homepage ? 'Visible' : 'Hidden';
                            }
                        } else {
                            this.checked = !this.checked;
                            alert('Unable to update.');
                        }
                    } catch(err) {
                        this.checked = !this.checked;
                        alert('Network error. Please try again.');
                    }
                    this.disabled = false;
                });
            });
        }

        document.addEventListener('DOMContentLoaded', wireToggles);
    })();
</script>

<!-- Success Alert -->
@if($message = session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ $message }}
    </div>
@endif

<!-- Search Bar -->
<form method="GET" class="search-bar">
    <input type="text" name="search" placeholder="Search cities..." value="{{ $search }}" style="flex:1;">
    
    <select name="per_page" onchange="this.form.submit()">
        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 per page</option>
        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 per page</option>
        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 per page</option>
    </select>

    <button type="submit"><i class="fas fa-search"></i> Search</button>
    <a href="{{ route('admin.cities.index') }}" class="btn-primary" style="background: #6c757d;">Reset</a>
</form>

<!-- Table Container -->
<div class="table-container">
    @if($cities->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>City Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Homepage</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cities as $city)
                    <tr>
                        <td>
                            @if($city->image)
                                <img src="{{ asset('storage/' . $city->image) }}" alt="{{ $city->name }}" class="img-thumbnail">
                            @else
                                <span style="color: #ccc;">No Image</span>
                            @endif
                        </td>
                        <td><strong>{{ $city->name }}</strong></td>
                        <td>{{ Str::limit($city->description, 50) }}</td>
                        <td>
                            <label style="display:inline-flex;align-items:center;gap:10px;">
                                <input type="checkbox" class="toggle-checkbox toggle-status" data-url="{{ route('admin.cities.toggleStatus', $city) }}" data-id="{{ $city->id }}" {{ $city->status ? 'checked' : '' }}>
                                <span class="status-text">{{ $city->status ? 'Active' : 'Inactive' }}</span>
                            </label>
                        </td>
                        <td>
                            <label style="display:inline-flex;align-items:center;gap:10px;">
                                <input type="checkbox" class="toggle-checkbox toggle-homepage" data-url="{{ route('admin.cities.toggleHomepage', $city) }}" data-id="{{ $city->id }}" {{ $city->visible_on_homepage ? 'checked' : '' }}>
                                <span class="status-text">{{ $city->visible_on_homepage ? 'Visible' : 'Hidden' }}</span>
                            </label>
                        </td>
                        <td>{{ $city->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" onclick="window.location='{{ route('admin.cities.edit', $city) }}';" class="btn-sm btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" action="{{ route('admin.cities.destroy', $city) }}" style="display:inline;" class="ajax-delete-form">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn-sm btn-delete ajax-delete-btn">
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
            {{ $cities->links() }}
        </div>
    @else
        <div class="no-data">
            <i class="fas fa-inbox"></i>
            <p>No cities found. <a href="{{ route('admin.cities.create') }}" style="color: #667eea;">Create one now</a></p>
        </div>
    @endif
</div>
        <!-- Toast container -->
        <div id="toast" class="toast-notification" role="status" aria-live="polite" style="display:none;"></div>

        <script>
            (function(){
                const csrfToken = '{{ csrf_token() }}';

                function showToast(message, duration = 3000){
                    const el = document.getElementById('toast');
                    if (!el) return;
                    el.textContent = message;
                    el.style.display = 'block';
                    requestAnimationFrame(()=> el.classList.add('show'));
                    clearTimeout(el._hideTimer);
                    el._hideTimer = setTimeout(()=>{
                        el.classList.remove('show');
                        setTimeout(()=> el.style.display = 'none', 250);
                    }, duration);
                }

                // intercept forms with data-confirm to perform AJAX delete
                document.addEventListener('DOMContentLoaded', function(){
                    // Attach AJAX delete handlers to forms with class .ajax-delete-form
                    document.querySelectorAll('form.ajax-delete-form').forEach(form => {
                        const btn = form.querySelector('.ajax-delete-btn');
                        if (!btn) return;
                        btn.addEventListener('click', async function (e) {
                            e.preventDefault();
                            const confirmMsg = form.dataset.confirm || 'Delete this city?';
                            if (!confirm(confirmMsg)) return;
                            const url = form.action;
                            const row = form.closest('tr');
                            try {
                                const res = await fetch(url, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json'
                                    }
                                });
                                if (res.ok) {
                                    if (row) {
                                        row.style.transition = 'opacity .35s ease, transform .35s ease, height .35s ease, margin .35s ease';
                                        row.style.opacity = '0';
                                        row.style.transform = 'translateX(-20px)';
                                        row.style.height = '0';
                                        row.style.margin = '0';
                                        setTimeout(() => { row.remove(); }, 380);
                                    }
                                    showToast('City Delete Successfully');
                                } else {
                                    let json = null;
                                    try { json = await res.json(); } catch(_){ }
                                    const msg = (json && (json.message || json.error)) ? (json.message || json.error) : 'Delete failed';
                                    alert(msg);
                                }
                            } catch (err) {
                                alert('Network error. Please try again.');
                            }
                        });
                    });
                });
            })();
        </script>
@endsection