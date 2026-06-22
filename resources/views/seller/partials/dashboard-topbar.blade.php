<header class="dashboard-topbar shadow-sm">
    <div class="topbar-start d-flex align-items-center gap-3">
        <button class="btn btn-ghost btn-sm sidebar-toggle d-lg-none" type="button" aria-expanded="false" aria-controls="dashboard-sidebar">
            <i class="bi bi-list"></i>
            <span class="visually-hidden">Toggle navigation</span>
        </button>

        <div>
            <p class="text-muted small mb-1">Seller Workspace</p>
            <h1 class="h5 mb-0">CampusFreelance Seller</h1>
        </div>
    </div>

    <div class="topbar-end d-flex align-items-center gap-2">
        <form class="search-form d-none d-md-flex" role="search" aria-label="Search dashboard">
            <input type="search" class="form-control form-control-sm" placeholder="Search services, orders..." aria-label="Search" />
            <button class="btn btn-primary btn-sm" type="submit"><i class="bi bi-search"></i></button>
        </form>

        <button class="btn btn-outline-secondary btn-icon" id="themeToggle" type="button" aria-label="Toggle theme">
            <i class="bi bi-moon"></i>
        </button>

        <a href="#" class="btn btn-outline-secondary btn-icon" aria-label="Notifications">
            <i class="bi bi-bell"></i>
        </a>

        <a href="#" class="btn btn-outline-secondary btn-icon" aria-label="Messages">
            <i class="bi bi-chat-dots"></i>
        </a>

        <div class="dropdown profile-dropdown">
            <button class="btn btn-outline-secondary btn-icon dropdown-toggle" type="button" id="sellerProfileMenuButton" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Open profile menu">
                <i class="bi bi-person-circle"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sellerProfileMenuButton">
                <li><a class="dropdown-item" href="{{ route('seller.profile') }}">My Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('seller.settings') }}">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item">Sign Out</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
