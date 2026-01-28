<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Indian Cities Admin') - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR STYLES ===== */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar-logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
        }

        .sidebar-logo i {
            font-size: 28px;
        }

        .sidebar-menu {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .sidebar-menu li {
            margin: 5px 0;
        }

        .sidebar-menu a,
        .sidebar-menu button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
        }

        .sidebar-menu a:hover,
        .sidebar-menu button:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding-left: 18px;
        }

        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            border-left: 3px solid white;
            padding-left: 12px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
            }

            .main-content {
                margin-left: 250px;
                padding: 15px;
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                position: fixed;
                width: 100%;
                height: auto;
                max-height: 300px;
                z-index: 999;
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
                margin-top: 300px;
            }

            .sidebar-menu {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <div class="admin-container">
        <!-- ===== SIDEBAR ===== -->
        @include('layouts.sidebar')

        <!-- ===== MAIN CONTENT ===== -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Global confirm modal (used for logout/delete confirmations) -->
    <div id="confirmModal" class="confirm-modal" aria-hidden="true" style="display:none;">
        <div class="confirm-modal-overlay"></div>
        <div class="confirm-modal-panel">
            <h3 class="confirm-modal-title">Please Confirm</h3>
            <p class="confirm-modal-message">Are you sure?</p>
            <div class="confirm-modal-actions">
                <button type="button" class="confirm-btn">Confirm</button>
                <button type="button" class="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>

    <style>
        .confirm-modal { position: fixed; inset: 0; z-index: 2000; display: flex; align-items: center; justify-content: center; }
        .confirm-modal-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.4); }
        .confirm-modal-panel { position: relative; background: #fff; width: 420px; max-width: 90%; border-radius: 8px; padding: 22px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); text-align: left; }
        .confirm-modal-title { margin: 0 0 8px; font-size: 18px; font-weight: 600; }
        .confirm-modal-message { margin: 0 0 18px; color: #333; }
        .confirm-modal-actions { display: flex; gap: 10px; justify-content: flex-end; }
        .confirm-btn { background: #007aa3; color: #fff; border: none; padding: 10px 16px; border-radius: 6px; cursor: pointer; }
        .cancel-btn { background: transparent; color: #007aa3; border: 2px solid #007aa3; padding: 8px 14px; border-radius: 6px; cursor: pointer; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('confirmModal');
            if (!modal) return;
            var msgEl = modal.querySelector('.confirm-modal-message');
            var confirmBtn = modal.querySelector('.confirm-btn');
            var cancelBtn = modal.querySelector('.cancel-btn');
            var currentForm = null;
            var lastClickedButton = null;
            var bypass = false;

            function openModal(message) {
                msgEl.textContent = message || 'Are you sure?';
                modal.style.display = 'flex';
                modal.setAttribute('aria-hidden', 'false');
            }

            function closeModal() {
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
                currentForm = null;
            }

            // Intercept submission of forms that have a data-confirm attribute.
            // We listen for both the `submit` event and clicks on submit buttons to
            // cover cases like `display: contents` forms and buttons with a
            // `form` attribute.
            document.querySelectorAll('form[data-confirm]').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    if (bypass) return; // allow programmatic submits
                    e.preventDefault();
                    currentForm = this;
                    openModal(this.getAttribute('data-confirm') || 'Are you sure?');
                });
            });

            // Delegated click handler for submit buttons or inputs inside (or targeting) forms
            document.addEventListener('click', function (e) {
                var btn = e.target.closest('button[type="submit"], input[type="submit"], a[data-confirm][data-form]');
                if (!btn) return;

                // If the clicked element is an anchor with data-form, use that selector
                var targetForm = null;
                if (btn.tagName.toLowerCase() === 'a') {
                    var sel = btn.getAttribute('data-form');
                    if (!sel) return;
                    targetForm = document.querySelector(sel);
                } else {
                    // For buttons/inputs, the `.form` property points to the associated form
                    targetForm = btn.form || null;
                }

                if (!targetForm) return;
                if (!targetForm.hasAttribute('data-confirm')) return;

                // remember last clicked button (used as fallback if currentForm becomes null)
                lastClickedButton = btn;

                // Prevent the default action and show modal
                e.preventDefault();
                currentForm = targetForm;
                openModal(targetForm.getAttribute('data-confirm') || btn.getAttribute('data-confirm') || 'Are you sure?');
            });

            confirmBtn.addEventListener('click', function () {
                if (!currentForm) {
                    // attempt to recover the form from the last clicked button
                    if (lastClickedButton) {
                        if (lastClickedButton.tagName.toLowerCase() === 'a') {
                            var sel = lastClickedButton.getAttribute('data-form');
                            if (sel) currentForm = document.querySelector(sel);
                        } else {
                            currentForm = lastClickedButton.form || null;
                        }
                    }
                }

                if (!currentForm) { closeModal(); return; }
                bypass = true;
                closeModal();
                try {
                    currentForm.submit();
                } catch (err) {
                    // fallback: dispatch a submit event if direct submit fails
                    try { currentForm.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true })); } catch(e) {}
                }
                setTimeout(function () { bypass = false; }, 200);
            });

            cancelBtn.addEventListener('click', function () {
                closeModal();
            });
        });
    </script>

    <script>
        // Live AJAX search for any form with class 'search-bar'
        (function(){
            let debounceTimer = null;

            function serializeForm(form){
                const params = new URLSearchParams();
                new FormData(form).forEach((v,k) => { params.append(k, v); });
                return params.toString();
            }

            async function ajaxLoad(url, containerSelector){
                try {
                    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    if (!res.ok) return;
                    const html = await res.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContainer = doc.querySelector(containerSelector);
                    const cur = document.querySelector(containerSelector);
                    if (newContainer && cur) cur.innerHTML = newContainer.innerHTML;
                } catch(e){ console.error('Live search error', e); }
            }

            document.addEventListener('input', function(e){
                const input = e.target.closest && e.target.closest('.search-bar input[type="text"], .search-bar input[type="search"]');
                if (!input) return;
                const form = input.closest('form');
                if (!form) return;
                // decide target container
                const container = form.dataset.target || '.table-container';
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(()=>{
                    const qs = serializeForm(form);
                    const url = (form.action || window.location.pathname) + (qs ? ('?' + qs) : '');
                    ajaxLoad(url, container);
                }, form.dataset && form.dataset.debounce ? parseInt(form.dataset.debounce) : 350);
            }, { passive: true });

            // Intercept pagination links inside containers (but allow links marked with data-no-ajax or external targets)
            document.addEventListener('click', function(e){
                const a = e.target.closest('.table-container a, .pagination a');
                if (!a) return;
                // allow explicit bypass
                if (a.hasAttribute('data-no-ajax')) return;
                // allow links that open in new tab
                if (a.target && a.target !== '' && a.target !== '_self') return;
                const href = a.getAttribute('href');
                if (!href) return;
                // find nearest search form to determine container
                const form = document.querySelector('.search-bar');
                const container = form ? (form.dataset.target || '.table-container') : '.table-container';
                e.preventDefault();
                ajaxLoad(href, container);
            });
        })();
    </script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>