<aside class="sidebar">
    <div class="sidebar-logo">
        <i class="fas fa-city"></i>
        <span>Admin Panel</span>
    </div>

    <ul class="sidebar-menu">
        <!-- Dashboard -->
        <li>
            <a href="{{ route('admin.dashboard') }}" 
               class="@if(Route::currentRouteName() == 'admin.dashboard') active @endif">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Cities -->
        <li>
            <a href="{{ route('admin.cities.index') }}" 
               class="@if(str_contains(Route::currentRouteName(), 'cities')) active @endif">
                <i class="fas fa-building"></i>
                <span>Cities</span>
            </a>
        </li>

        <!-- News -->
        <li>
            <a href="{{ route('admin.news.index') }}" 
               class="@if(str_contains(Route::currentRouteName(), 'news')) active @endif">
                <i class="fas fa-newspaper"></i>
                <span>News</span>
            </a>
        </li>

        <!-- Videos -->
        <li>
            <a href="{{ route('admin.videos.index') }}" 
               class="@if(str_contains(Route::currentRouteName(), 'videos')) active @endif">
                <i class="fas fa-video"></i>
                <span>Videos</span>
            </a>
        </li>

        <!-- Home Content -->
        <li>
            <a href="{{ route('admin.home_content.index') }}" 
               class="@if(str_contains(Route::currentRouteName(), 'home_content')) active @endif">
                <i class="fas fa-home-lg"></i>
                <span>Home Content</span>
            </a>
        </li>

        <!-- Logout -->
        <li>
            <form id="sidebar-logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                @csrf
            </form>

            <a href="{{ route('logout') }}" onclick="event.preventDefault(); if(confirm('Are you sure you want to logout?')) { document.getElementById('sidebar-logout-form').submit(); }" class="logout-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>