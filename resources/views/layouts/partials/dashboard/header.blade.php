<!-- Navbar -->
<nav class="navbar navbar-expand navbar-white navbar-light">
    {{-- <a href="/" class="navbar-brand">
        <span class="brand-text font-weight-light">Recruitment</span>
    </a> --}}

    <!-- Navbar Right Menu -->
    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    <ul class="navbar-nav ml-auto">
        @guest
            <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link">Login</a>
            </li>
        @endguest
@auth
    @if(Auth::user()->role == 'admin')
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-link nav-link">Logout</button>
            </form>
        </li>

    @elseif(Auth::user()->role == 'applicant')
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ Auth::user()->applicantProfile->photo_path ? asset('storage/'.Auth::user()->applicantProfile->photo_path) : asset('default-avatar.png') }}"
                     class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">Halo, {{ Auth::user()->applicantProfile->surname ?? Auth::user()->email }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="{{ Auth::user()->applicantProfile->photo_path ? asset('storage/'.Auth::user()->applicantProfile->photo_path) : asset('default-avatar.png') }}"
                         class="img-circle elevation-2" alt="User Image">
                    <p>
                        {{ Auth::user()->applicantProfile->full_name ?? 'Pelamar' }}
                        <small>{{ Auth::user()->email }}</small>
                    </p>
                </li>

                <!-- Menu Body -->
                <li class="user-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <a href="{{ route('applicant.profile') }}">Profil Saya</a>
                        </div>
                    </div>
                </li>

                <!-- Menu Footer -->
                <li class="user-footer d-flex  justify-content-center">
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-flat float-right">Logout</button>
                    </form>
                </li>
            </ul>
        </li>
    @endif
@endauth
    </ul>
</nav>
