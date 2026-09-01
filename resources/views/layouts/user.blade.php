<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Cinevo')</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-light">

    <!-- Topbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center me-2"
                    style="width:36px; height:36px;">
                    <span class="fa fa-film text-secondary"></span>
                </div>
                Cinevo
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navUser">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navUser">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#sedang-tayang">Sedang Tayang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#segera-tayang">Segera Tayang</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @guest
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-secondary btn-sm" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-danger btn-sm" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                                data-bs-toggle="dropdown">
                                <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center me-2"
                                    style="width:32px; height:32px;">
                                    <span class="fa fa-user text-secondary"></span>
                                </div>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Ubah Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </ul>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <!-- End of Topbar -->

    <!-- Main Content -->
    <div class="py-4">
        @yield('content')
    </div>
    <!-- End of Main Content -->

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (Session::has('success'))
        <script type="text/javascript">
            Swal.fire({
                title: "Berhasil!!",
                text: "{{ Session::get('success') }}",
                icon: "success",
                draggable: true
            });
        </script>
    @endif

    @stack('scripts')

</body>
</html>