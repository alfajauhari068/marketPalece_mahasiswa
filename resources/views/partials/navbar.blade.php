<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="#">CampusFreelance</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-secondary" href="#" id="browseDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Telusuri Jasa
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="browseDropdown">
                        <li><a class="dropdown-item" href="#design">Desain</a></li>
                        <li><a class="dropdown-item" href="#programming">Pemrograman</a></li>
                        <li><a class="dropdown-item" href="#writing">Penulisan</a></li>
                        <li><a class="dropdown-item" href="#marketing">Marketing</a></li>
                    </ul>
                </li>
            </ul>

            <form class="d-flex mx-auto search-bar w-100 w-lg-50 me-lg-3" role="search">
                <input class="form-control rounded-pill border-0 shadow-sm" type="search" placeholder="Cari jasa, kategori, atau nama freelancer" aria-label="Search">
                <button class="btn btn-primary rounded-pill ms-2 px-4" type="submit">Cari</button>
            </form>

            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                <button class="btn btn-outline-secondary rounded-pill px-3" id="themeToggle" type="button" aria-label="Toggle theme">
                    <i class="bi bi-moon"></i>
                </button>
                <a class="nav-link text-secondary" href="/login">Masuk</a>
                <a class="btn btn-primary rounded-pill px-4" href="#">Daftar</a>
            </div>
        </div>
    </div>
</nav>