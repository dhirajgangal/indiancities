@extends('layouts.admin')

@section('title', 'Cities Management')

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

    .img-thumbnail {
        width: 50px;
        height: 50px;
        border-radius: 6px;
        object-fit: cover;
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
    /* toast notification */
    .toast-notification {
        position: fixed; left: 50%; transform: translateX(-50%) translateY(20px);
        bottom: 24px; background: #16a34a; color: #fff; padding: 12px 18px; border-radius: 8px; box-shadow: 0 8px 24px rgba(16,24,40,0.2); z-index: 1200; opacity: 0; pointer-events: none; transition: opacity .25s ease, transform .25s ease;
    }
    .toast-notification.show { opacity: 1; transform: translateX(-50%) translateY(0); pointer-events: auto; }
</style>
@endsection

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