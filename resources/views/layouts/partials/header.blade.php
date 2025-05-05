<!-- Navbar -->
<nav class="navbar navbar-expand navbar-white navbar-light">
    <a href="/" class="navbar-brand">
        <span class="brand-text font-weight-light">Recruitment</span>
    </a>

    <!-- Navbar Right Menu -->
    <ul class="navbar-nav ml-auto">
        @guest
            <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link">Login</a>
            </li>
        @endguest
        @auth
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-link nav-link">Logout</button>
                </form>
            </li>
        @endauth
    </ul>
</nav>
