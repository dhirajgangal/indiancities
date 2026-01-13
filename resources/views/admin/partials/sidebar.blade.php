<aside class="sidebar">
    <div class="sidebar-logo">
        <i class="fas fa-city"></i> Admin Panel
    </div>
    <ul class="sidebar-menu">
        <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.cities.index') }}" class="{{ request()->routeIs('admin.cities.*') ? 'active' : '' }}"><i class="fas fa-building"></i> Cities</a></li>
        <li><a href="#"><i class="fas fa-newspaper"></i> News</a></li>
        <li><a href="#"><i class="fas fa-video"></i> Videos</a></li>
        <li><a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Profile</a></li>
        <li>
            <form id="admin-sidebar-logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                @csrf
            </form>

            <button onclick="event.preventDefault(); if(confirm('Are you sure you want to logout?')) document.getElementById('admin-sidebar-logout-form').submit();" style="background:none; border:none; color:rgba(255,255,255,0.8); cursor:pointer; text-align:left; width:100%; padding:12px 15px; border-radius:6px; transition:all 0.3s ease; display:flex; align-items:center; gap:12px;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </li>
    </ul>
</aside>
