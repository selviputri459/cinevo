<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('title')</title>

    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,500,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-admin.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

    @stack('styles')

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
</head>

<body id="page-top" class="cinevo-admin-body">

    <div id="wrapper">

        @include('layouts.inc.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                @include('layouts.inc.navbar')

                <div class="container-fluid">
                    @yield('content')
                </div>

            </div>

            @include('layouts.inc.footer')

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

</body>
</html>