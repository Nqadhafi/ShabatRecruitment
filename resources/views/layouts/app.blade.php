<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AdminLTE Dashboard')</title>
    
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    
    @stack('css')  <!-- Optional: Stack CSS for page-specific styles -->
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Main Header -->
        @include('layouts.partials.dashboard.header')

        <!-- Sidebar -->
        @include('layouts.partials.dashboard.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                @yield('content_header')
            </div>

            <!-- Main Content -->
            <div class="content">
                @yield('content')
            </div>
        </div>

        <!-- Main Footer -->
        @include('layouts.partials.dashboard.footer')

    </div>

    <!-- AdminLTE JS -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
    
    @stack('scripts') <!-- Optional: Stack JS for page-specific scripts -->
</body>
</html>
