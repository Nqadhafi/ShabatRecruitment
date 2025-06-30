<!-- Main Sidebar Container -->
                @auth
                    @if(Auth::user()->role == 'admin')
<aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="{{ asset('app/img/Logo_square.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Portal HRD</span>
    </a>
                    @elseif(Auth::user()->role == 'applicant')
<aside class="main-sidebar sidebar-light-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="{{ asset('app/img/Logo_square.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Portal Pelamar</span>
    </a>
                    @endif
                @endauth

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @auth
                    @if(Auth::user()->role == 'admin')
                        @include('admin.sidebar')
                    @elseif(Auth::user()->role == 'applicant')
                        @include('applicant.sidebar')
                    @endif
                @endauth
            </ul>
        </nav>
    </div>
</aside>
