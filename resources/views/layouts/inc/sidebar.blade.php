<ul class="navbar-nav cinevo-admin-sidebar sidebar accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="{{ route('admin.dashboard') }}">
        <div class="cinevo-admin-brand">
            <div class="cinevo-admin-brand-logo">
                <img src="{{ asset('img/logo.png') }}" alt="Cinevo">
            </div>
            <span>Cinevo Admin</span>
        </div>
    </a>
    <hr class="sidebar-divider">
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span>
        </a>
    </li>
    <div class="cinevo-admin-section-title">MENU</div>
    <li class="nav-item {{ request()->routeIs('admin.film.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ Route::has('admin.film.index') ? route('admin.film.index') : '#' }}">
            <i class="fas fa-fw fa-film"></i><span>Film</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.showtime.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ Route::has('admin.showtime.index') ? route('admin.showtime.index') : '#' }}">
            <i class="fas fa-fw fa-calendar-alt"></i><span>Jadwal Tayang</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.studio.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ Route::has('admin.studio.index') ? route('admin.studio.index') : '#' }}">
            <i class="fas fa-fw fa-door-open"></i><span>Studio</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.booking.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ Route::has('admin.booking.index') ? route('admin.booking.index') : '#' }}">
            <i class="fas fa-fw fa-ticket-alt"></i><span>Booking</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.data-admin.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.data-admin.index') }}">
            <i class="fas fa-fw fa-user-shield"></i><span>Admin</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="text-center d-none d-md-inline mt-2">
    <button class="rounded-circle border-0 cinevo-sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-chevron-left"></i>
    </button>
</div>
</ul>