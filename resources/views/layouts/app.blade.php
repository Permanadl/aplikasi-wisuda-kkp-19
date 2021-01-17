<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Aplikasi Wisuda STMIK Sumedang">
  <meta name="author" content="STMIK Sumedang">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="{{ asset('img/logo/logo.png') }}" rel="icon">
  <title>@yield('title') | Aplikasi Wisuda</title>
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/app-wisuda.min.css') }}" rel="stylesheet">
  @stack('css')
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    @include('layouts.sidebar')
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        @include('layouts.topbar')
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          @yield('breadcrumb')

          @yield('content')

        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; {{ date('Y') }} - 
              <b><a href="https://stmik-sumedang.ac.id/" target="_blank">STMIK Sumedang</a></b>
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/app-wisuda.min.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>  
  @stack('js')
</body>

</html>