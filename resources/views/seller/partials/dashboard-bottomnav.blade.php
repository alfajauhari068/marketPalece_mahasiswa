<nav class="dashboard-bottomnav d-lg-none" aria-label="Bottom navigation">
    <a href="{{ route('seller.dashboard') }}" class="bottomnav-item {{ isset($active) && $active === 'dashboard' ? 'active' : '' }}" aria-label="Dashboard">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('seller.services.index') }}" class="bottomnav-item {{ isset($active) && $active === 'services' ? 'active' : '' }}" aria-label="Services">
        <i class="bi bi-grid-3x3-gap"></i>
        <span>Services</span>
    </a>
    <a href="{{ route('seller.orders.index') }}" class="bottomnav-item {{ isset($active) && $active === 'orders' ? 'active' : '' }}" aria-label="Orders">
        <i class="bi bi-bag-check"></i>
        <span>Orders</span>
    </a>
    <a href="{{ route('seller.earnings.index') }}" class="bottomnav-item {{ isset($active) && $active === 'earnings' ? 'active' : '' }}" aria-label="Earnings">
        <i class="bi bi-wallet2"></i>
        <span>Earnings</span>
    </a>
</nav>
