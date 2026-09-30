<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Cinevo')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    {{-- Font Awesome --}}
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Google Font --}}
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900"
        rel="stylesheet">
    {{-- CSS Cinevo --}}
    <link rel="stylesheet" href="{{ asset('css/cinevo.css') }}">
    @stack('styles')
</head>
<body class="cinevo-body">

    {{--NAVBAR--}}
    <nav class="navbar navbar-expand-lg cinevo-navbar">
        <div class="container">

            {{-- Logo --}}
            <a class="navbar-brand cinevo-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Cinevo" class="cinevo-logo me-2">
                <span>Cinevo</span>
            </a>

            {{-- Mobile Toggle --}}
            <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navUser"
                aria-controls="navUser"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Navigation --}}
            <div class="collapse navbar-collapse" id="navUser">
                {{-- Menu Tengah --}}
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link cinevo-nav-link" href="{{ url('/') }}#sedang-tayang">Sedang Tayang</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link cinevo-nav-link" href="{{ url('/') }}#segera-tayang"> Segera Tayang </a>
                    </li>
                </ul>

                {{-- Menu Kanan --}}
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @guest
                        {{-- Masuk --}}
                        <li class="nav-item me-lg-2 mb-2 mb-lg-0">
                            <a href="{{ route('login') }}" class="btn cinevo-btn-outline btn-sm">Masuk</a>
                        </li>

                        {{-- Daftar --}}
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn cinevo-btn-primary btn-sm">Daftar</a>
                        </li>
                    @else

                        {{-- User Dropdown --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle cinevo-user d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="cinevo-user-icon">
                                    @if(auth()->user()->profile_photo)
                                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                            alt="Foto profil">
                                    @else
                                        <i class="fas fa-user"></i>
                                    @endif
                                </div>

                                <span>{{ auth()->user()->name }}</span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end cinevo-dropdown"
                                aria-labelledby="userDropdown">

                                <li>
                                    <a class="dropdown-item cinevo-dropdown-item" href="{{ route('profile') }}">
                                        <i class="fas fa-user-edit me-2"></i>
                                        Ubah Profil
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item cinevo-dropdown-item" href="{{ route('booking.index') }}">
                                        <i class="fas fa-ticket-alt me-2"></i>
                                        Riwayat Booking
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider cinevo-divider">
                                </li>

                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf

                                        <button type="submit" class="dropdown-item cinevo-dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>


    {{-- MAIN CONTENT --}}
    <main class="cinevo-main">
        @yield('content')
    </main>

        @include('partials.footer')

    {{-- SCRIPTS --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    {{-- Bootstrap 5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- Success Message --}}
    @if (Session::has('success'))
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "{{ Session::get('success') }}",
                icon: "success",
                confirmButtonText: "OK"
            });
        </script>
    @endif
    @stack('scripts')
</body>
</html>