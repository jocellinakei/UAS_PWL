<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
        <style>
        /* Ganti warna background dari putih ke #fdf6ec */
        body,
        .bg-white,
        .navbar-light,
        .topbar,
        .sticky-footer,
        .card,
        .dropdown-menu,
        .modal-content {
            background-color: #fdf6ec !important;
        }

        /* Ganti warna sidebar dari biru gradient menjadi #f66631 */
        .bg-gradient-primary,
        .sidebar-dark .sidebar {
            background-color: #f66631 !important;
            background-image: none !important;
        }

        /* Primary button color juga perlu disesuaikan */
        .btn-primary {
            background-color: #f66631;
            border-color: #f66631;
        }

        .btn-primary:hover {
            background-color: #e55520;
            border-color: #e55520;
        }

        /* Penyesuaian warna text di sidebar */
        .sidebar-dark .nav-item .nav-link {
            color: rgba(255, 255, 255, 0.9);
        }
    </style>

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">
</head>
<body class="bg-gradient-primary min-vh-100 d-flex justify-content-center align-items-center">

@yield('main-content')

<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>
</html>
