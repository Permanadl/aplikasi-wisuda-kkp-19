<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Wisuda - STMIK Sumedang</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shorcut icon" href="{{ asset('assets/img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/navbar-top-fixed.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fa/css/fontawesome-all.min.css') }}">
    @stack('css')
</head>

<body>
    <nav class="navbar bg-light fixed-top header">
        <a class="navbar-brand mr-5" href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="" height="50">
        </a>
        <a href="{{ route('login') }}" class="text-uppercase text-dark nav-link font-weight-bold">
            <i class="fa fa-sign-in-alt fa-1x"></i>
            Masuk
        </a>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-blue bg-blue border-bottom shadow-sm">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto font-weight-bold text-uppercase">
                <li class="nav-item">
                    <a class="nav-link {{ Request::segment(1) == null ? 'active' : '' }}" href="{{ route('home') }}">
                        Beranda <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::segment(1) == 'list-wisudawan' || Request::segment(1) == 'profil-wisudawan' ? 'active' : '' }}" href="{{ route('listWisudawan') }}">data Wisudawan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::segment(1) == 'statistik' ? 'active' : '' }}" href="{{ route('statistik') }}">Statistik</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::segment(1) == 'testimonial' ? 'active' : '' }}" href="{{ route('testimoni') }}">testimoni</a>
                </li>
            </ul>
        </div>
    </nav>
    @yield('content')
    <footer class="bg-blue footer">
        <div class="text-center p-2">
            Copyright &copy; 2020. <a href="https://stmik-sumedang.ac.id" class="footer-link" target="_blank"> STMIK
                SUMEDANG</a>. All Rights Reserved
        </div>
    </footer>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
    crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
@stack('js')
</html>