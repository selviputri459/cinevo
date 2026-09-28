<nav class="navbar navbar-expand navbar-dark cinevo-admin-navbar sticky-top">
    <div class="container-fluid">
        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle cinevo-admin-user" href="#" id="adminUserDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="cinevo-admin-user-icon">
                        @if(auth('admin')->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth('admin')->user()->profile_photo) }}" alt="Foto profil">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </span>
                    <span class="cinevo-admin-user-name">{{ auth('admin')->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right cinevo-admin-dropdown" aria-labelledby="adminUserDropdown">
                    <a class="dropdown-item cinevo-admin-dropdown-item" href="{{ route('admin.profile') }}">
                        <i class="fas fa-user-edit"></i>
                        <span>Ubah Profil</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item cinevo-admin-dropdown-item">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>