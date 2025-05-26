    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Logo PELNI -->
            <a class="navbar-brand" href="#">
                <img src="{{ asset('app/img/Logo_panjang.png')}}" alt="Shabat Printing Logo" class="img-fluid" style="width: 8rem;">
            </a>
            
            <!-- Register and Login Buttons (Always Visible) -->
            <div class="d-lg-none ml-auto mr-2">
                <a href="#" class="mr-1">
                    
                    <button class="btn btn-outline-primary"><ion-icon name="create-outline"></ion-icon><span class="d-none d-lg-block">Daftar Akun</span></button>
                </a>
                <a href="#">
                    
                    <button class="btn btn-primary"><ion-icon name="log-in"></ion-icon><p class="d-none d-lg-block">Masuk</p></button>
                </a>
            </div>

            <!-- Toggle Button for Small Screens -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <!-- Menu items -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#jobs">Lowongan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                </ul>
            </div>

            <!-- Register and Login Buttons (Desktop View) -->
            <div class="d-none d-lg-flex ml-auto">
                <a href="#" class="mr-2">
                    <button class="btn btn-outline-primary d-flex"><ion-icon name="create-outline" class="align-self-center mr-1"></ion-icon><span>Daftar Akun</span></button>
                </a>
                <a href="#">
                    
                    <button class="btn btn-primary d-flex"><ion-icon name="log-in" class="align-self-center mr-1"></ion-icon><span>Masuk</span></button>
                </a>
            </div>
        </div>
    </nav>