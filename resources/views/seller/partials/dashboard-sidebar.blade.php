<aside class="dashboard-sidebar-panel" aria-label="Primary navigation">
    <div class="sidebar-brand">
        <a href="{{ route('seller.dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
            <span class="sidebar-badge bg-primary bg-opacity-10 text-primary"><i class="bi bi-lightning-charge-fill"></i></span>
            <div>
                <p class="mb-0 fw-bold">CampusFreelance</p>
                <small class="text-muted">Seller Workspace</small>
            </div>
        </a>
    </div>

    <nav class="nav flex-column dashboard-nav" role="navigation">
        <a href="{{ route('seller.dashboard') }}" class="nav-link rounded-4 {{ isset($active) && $active === 'dashboard' ? 'active' : '' }}" aria-current="page">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('seller.services.index') }}" class="nav-link rounded-4 {{ isset($active) && $active === 'services' ? 'active' : '' }}">
            <i class="bi bi-grid-3x3-gap"></i> My Services
        </a>
        <a href="{{ route('seller.orders.index') }}" class="nav-link rounded-4 {{ isset($active) && $active === 'orders' ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Orders
        </a>
        <a href="{{ route('seller.reviews.index') }}" class="nav-link rounded-4 {{ isset($active) && $active === 'reviews' ? 'active' : '' }}">
            <i class="bi bi-star-fill"></i> Reviews
        </a>
        <a href="{{ route('seller.earnings.index') }}" class="nav-link rounded-4 {{ isset($active) && $active === 'earnings' ? 'active' : '' }}">
            <i class="bi bi-piggy-bank"></i> Earnings
        </a>
        <a href="{{ route('seller.profile') }}" class="nav-link rounded-4 {{ isset($active) && $active === 'profile' ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Profile
        </a>
        <a href="{{ route('seller.settings') }}" class="nav-link rounded-4 {{ isset($active) && $active === 'settings' ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Settings
        </a>
    </nav>
</aside>
