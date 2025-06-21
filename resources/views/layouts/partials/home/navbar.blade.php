<nav class="navbar navbar-expand-lg {{ Request::is('/') ? 'bg-transparent fixed-top w-100' : 'bg-white shadow-sm sticky-top' }} navbar-light">

        <div class="container d-flex justify-content-between align-items-center">
            <!-- Logo PELNI -->
            <a class="navbar-brand" href="#">
                <img src="{{ asset('app/img/Logo_white.png') }}" alt="Shabat Printing Logo" class="img-fluid"
                    style="width: 8rem;">
            </a>

            <!-- Register and Login Buttons (Always Visible) -->
            <div class="d-lg-none ml-auto mr-2">
                @auth
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Logout</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('register') }}" class="mr-1">

                        <button class="btn btn-outline-light button-nav-register"><ion-icon name="create-outline"></ion-icon><span
                                class="d-none d-lg-block">Daftar Akun</span></button>
                    </a>
                    <a href="{{ route('login') }}">

                        <button class="btn btn-light button-nav"><ion-icon name="log-in"></ion-icon>
                            <p class="d-none d-lg-block">Masuk</p>
                        </button>
                    </a>
                @endguest
            </div>

            <!-- Toggle Button for Small Screens -->
            <button class="navbar-toggler navbar-light" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon navbar-light"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <!-- Menu items -->
                    <li class="nav-item ">
                        <a class="nav-link text-white" href="/">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-white" href="/#jobs">Lowongan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/#about">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/#contact">Kontak</a>
                    </li>
                </ul>
            </div>

            <!-- Register and Login Buttons (Desktop View) -->
            <div class="d-none d-lg-flex ml-auto">
                @auth
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link ">Logout</button>
                    </form>

                @endauth
                @guest
                    <a href="{{ route('register') }}" class="mr-2">
                        <button class="btn btn-outline-light d-flex button-nav-register"><ion-icon name="create-outline"
                                class="align-self-center mr-1"></ion-icon><span>Daftar Akun</span></button>
                    </a>
                    <a href="{{ route('login') }}">

                        <button class="btn btn-light d-flex button-nav"><ion-icon name="log-in"
                                class="align-self-center mr-1"></ion-icon><span>Masuk</span></button>
                    </a>
                @endguest
            </div>
        </div>
    </nav>
    @if(Request::is('/'))
<script>
    window.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar');
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        const logo = document.querySelector('.navbar-brand img');
        const logoSrc = '{{ asset('app/img/Logo_panjang.png') }}';
        const logoSrcWhite = '{{ asset('app/img/Logo_white.png') }}';
        const navButton = document.querySelector('.navbar-toggler');
        const navButtonIcon = document.querySelector('.navbar-toggler-icon');
        const buttonNav = document.querySelectorAll('.button-nav');
        const buttonNavRegister = document.querySelectorAll('.button-nav-register');


        if (window.scrollY > 50) {
            navbar.classList.remove('bg-transparent', 'position-absolute');
            navbar.classList.add('bg-white', 'shadow-sm', 'sticky-top');
            navLinks.forEach(link => {
                link.classList.remove('text-white');
                link.classList.add('text-dark');
            });
            logo.src = logoSrc; // Change logo back to original version


            navButton.classList.remove('navbar-light');
            // navButton.classList.add('navbar-dark');
            buttonNav.forEach(button => {
                button.classList.remove('btn-light');
                button.classList.add('btn-primary');
            });
            buttonNavRegister.forEach(buttonNavRegister => {
            buttonNavRegister.classList.remove('btn-outline-light');
            buttonNavRegister.classList.add('btn-outline-primary');
            });
            
        } else {
            navbar.classList.remove('bg-white', 'shadow-sm', 'sticky-top');
            navbar.classList.add('bg-transparent', 'position-absolute');
            navLinks.forEach(link => {
                link.classList.remove('text-dark');
                link.classList.add('text-white');
            });
            navButton.classList.remove('navbar-dark');
            navButton.classList.add('navbar-light');
            
            logo.src = logoSrcWhite; // Change logo to white version
            buttonNav.forEach(button => {
                button.classList.remove('btn-primary');
                button.classList.add('btn-light');
            });

            buttonNavRegister.forEach(buttonNavRegister => {
            buttonNavRegister.classList.remove('btn-outline-primary');
            buttonNavRegister.classList.add('btn-outline-light');
            });

        }
    });
</script>
@endif
