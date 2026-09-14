<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-text mx-3">Cinevo Admin</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->routeIs('admin.film.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ Route::has('admin.film.index') ? route('admin.film.index') : '#' }}">
            <i class="fas fa-fw fa-film"></i>
            <span>Film</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ Route::has('admin.jadwal.index') ? route('admin.jadwal.index') : '#' }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Jadwal Tayang</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.studio.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ Route::has('admin.studio.index') ? route('admin.studio.index') : '#' }}">
            <i class="fas fa-fw fa-door-open"></i>
            <span>Studio</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.booking.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ Route::has('admin.booking.index') ? route('admin.booking.index') : '#' }}">
            <i class="fas fa-fw fa-ticket-alt"></i>
            <span>Booking</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.data-admin.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.data-admin.index') }}">
            <i class="fas fa-fw fa-user-shield"></i>
            <span>Admin</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>