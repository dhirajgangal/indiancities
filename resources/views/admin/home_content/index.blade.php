@extends('layouts.admin')

@section('title', 'Home Content')

@section('styles')
<style>
.table-container { background: white; border-radius: 10px; padding: 16px; }
.img-thumb { width: 120px; height: 60px; object-fit: cover; border-radius: 6px; }
.btn { padding: 8px 12px; border-radius: 6px; text-decoration: none; }
.btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; }
.btn-secondary { background: #ecf0f1; color: #333; }
.btn-sm { padding: 6px 10px; border-radius: 4px; }
/* header layout */
.page-header { display:flex; align-items:center; gap:12px; justify-content:space-between; margin-bottom:12px; }
.page-header h1 { margin:0; display:flex; align-items:center; gap:8px; font-size:1.25rem; }

/* action icons */
.actions { display:flex; gap:8px; align-items:center; }
.icon-btn { display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:6px; border:1px solid #e6e6e6; background:#fff; cursor:pointer; color:var(--icon-color,#374151); }
.icon-btn svg { width:18px; height:18px; stroke:currentColor; fill:none; }
.icon-btn:hover { background:#f8fafc; border-color:#d1d5db; }
.icon-delete { color:var(--icon-delete,#c53030); border-color:rgba(197,48,48,0.12); }
.sr-only { position:absolute !important; height:1px; width:1px; overflow:hidden; clip:rect(1px, 1px, 1px, 1px); white-space:nowrap; }
table thead th { text-align: left; padding: 10px 8px; border-bottom: 1px solid #eee; }
table tbody td { padding: 10px 8px; border-bottom: 1px solid #f5f5f5; }
.drag-handle { cursor: grab; padding: 8px 10px; }
.draggable-row { background: #fff; }
.draggable-row.dragging { opacity: 0.5; }
/* toast notification */
.toast-notification { position: fixed; left: 50%; transform: translateX(-50%) translateY(20px); bottom: 24px; background: #16a34a; color: #fff; padding: 12px 18px; border-radius: 8px; box-shadow: 0 8px 24px rgba(16,24,40,0.2); z-index: 1200; opacity: 0; pointer-events: none; transition: opacity .25s ease, transform .25s ease; }
.toast-notification.show { opacity: 1; transform: translateX(-50%) translateY(0); pointer-events: auto; }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1><i class="fas fa-home"></i> Banner section</h1>
    <a href="{{ route('admin.home_content.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Carousel Item</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-container">
    @if($items->count())
        <table id="carouselTable" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="width:40px">&nbsp;</th>
                    <th>Image</th>
                    <th>Order</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="draggable-row" data-id="{{ $item->id }}">
                    <td class="drag-handle" title="Drag to reorder"><i class="fas fa-grip-lines"></i></td>
                    <td>
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="img-thumb" alt="">
                        @else
                            <span style="color:#666;">No image</span>
                        @endif
                    </td>
                    <td class="order-cell">{{ $item->order }}</td>
                    <td>{{ $item->active ? 'Yes' : 'No' }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.home_content.edit', $item) }}" class="icon-btn" title="Edit" data-no-ajax="1">
                            <svg viewBox="0 0 24 24" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 21v-3a2 2 0 0 1 .6-1.4l11-11a2 2 0 0 1 2.8 0l1.6 1.6a2 2 0 0 1 0 2.8l-11 11A2 2 0 0 1 6 20H3z"></path>
                                <path d="M14 7l3 3"></path>
                            </svg>
                            <span class="sr-only">Edit</span>
                        </a>
                        <form method="POST" action="{{ route('admin.home_content.destroy', $item) }}" style="display:inline;" class="ajax-delete-form">
                            @csrf @method('DELETE')
                            <button type="button" class="icon-btn icon-delete ajax-delete-btn" title="Delete">
                                <svg viewBox="0 0 24 24" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                    <path d="M10 11v6M14 11v6"></path>
                                    <path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                <span class="sr-only">Delete</span>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:12px;">
            <button id="saveOrderBtn" class="btn btn-primary">Save Order</button>
            <span style="margin-left:12px;color:#666;font-size:13px;">Drag rows to reorder carousel items, then click Save Order.</span>
        </div>
    @else
        <p>No carousel items yet.</p>
    @endif
</div>
@endsection

@section('scripts')
<script>
    (function(){
        const table = document.getElementById('carouselTable');
        if (!table) return;

        let dragSrcRow = null;

        function handleDragStart(e) {
            dragSrcRow = this;
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            try { e.dataTransfer.setData('text/html', this.outerHTML); } catch(err) {}
        }

        function handleDragOver(e) {
            if (e.preventDefault) e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            return false;
        }

        function handleDrop(e) {
            if (e.stopPropagation) e.stopPropagation();
            if (dragSrcRow !== this) {
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                const srcIndex = rows.indexOf(dragSrcRow);
                const targetIndex = rows.indexOf(this);
                if (srcIndex < 0 || targetIndex < 0) return;
                if (srcIndex < targetIndex) {
                    this.after(dragSrcRow);
                } else {
                    this.before(dragSrcRow);
                }
            }
            return false;
        }

        function handleDragEnd() {
            this.classList.remove('dragging');
        }

        // wire events
        table.querySelectorAll('tbody tr').forEach(function(row){
            row.setAttribute('draggable', true);
            row.addEventListener('dragstart', handleDragStart, false);
            row.addEventListener('dragover', handleDragOver, false);
            row.addEventListener('drop', handleDrop, false);
            row.addEventListener('dragend', handleDragEnd, false);
        });

        document.getElementById('saveOrderBtn').addEventListener('click', async function(){
            const ids = Array.from(table.querySelectorAll('tbody tr')).map(r => r.dataset.id);
            const token = '{{ csrf_token() }}';
            const url = '{{ route('admin.home_content.reorder') }}';
            this.disabled = true;
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': token, 'Accept':'application/json' },
                    body: JSON.stringify({ order: ids })
                });
                const data = await res.json();
                if (data.success) {
                    // update order column visually
                    table.querySelectorAll('tbody tr').forEach((r, idx) => {
                        const cell = r.querySelector('.order-cell');
                        if (cell) cell.textContent = idx;
                    });
                    alert('Order saved');
                } else alert('Failed to save order');
            } catch(err) {
                alert('Network error');
            }
            this.disabled = false;
        });
        // toast container
        let toastEl = document.createElement('div');
        toastEl.id = 'hc_toast';
        toastEl.className = 'toast-notification';
        toastEl.style.display = 'none';
        document.body.appendChild(toastEl);

        function showToast(message, duration = 3000){
            toastEl.textContent = message;
            toastEl.style.display = 'block';
            requestAnimationFrame(()=> toastEl.classList.add('show'));
            clearTimeout(toastEl._hideTimer);
            toastEl._hideTimer = setTimeout(()=>{
                toastEl.classList.remove('show');
                setTimeout(()=> toastEl.style.display = 'none', 250);
            }, duration);
        }

        // Attach AJAX delete to carousel items
        document.querySelectorAll('form.ajax-delete-form').forEach(form => {
            const btn = form.querySelector('.ajax-delete-btn');
            if (!btn) return;
            btn.addEventListener('click', async function(e){
                e.preventDefault();
                const confirmMsg = form.dataset.confirm || 'Delete this item?';
                if (!confirm(confirmMsg)) return;
                const url = form.action;
                const row = form.closest('tr');
                try {
                    const res = await fetch(url, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                    });
                    if (res.ok){
                        if (row){
                            row.style.transition = 'opacity .35s ease, transform .35s ease, height .35s ease, margin .35s ease';
                            row.style.opacity = '0';
                            row.style.transform = 'translateX(-20px)';
                            row.style.height = '0';
                            row.style.margin = '0';
                            setTimeout(()=> row.remove(), 380);
                        }
                        showToast('Carousel item deleted');
                    } else {
                        let json = null; try{ json = await res.json(); } catch(_){}
                        const msg = (json && (json.message || json.error)) ? (json.message || json.error) : 'Delete failed';
                        alert(msg);
                    }
                } catch(err){
                    alert('Network error. Please try again.');
                }
            });
        });
    })();
</script>
@endsection
