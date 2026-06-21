<aside class="dashboard-sidebar-panel" aria-label="Primary navigation">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard.home') }}" class="text-decoration-none d-flex align-items-center gap-2">
            <span class="sidebar-badge bg-primary bg-opacity-10 text-primary"><i class="bi bi-lightning-charge-fill"></i></span>
            <div>
                <p class="mb-0 fw-bold">CampusFreelance</p>
                <small class="text-muted">Client Workspace</small>
            </div>
        </a>
    </div>

    <nav class="nav flex-column dashboard-nav" role="navigation">
        <a href="{{ route('dashboard.home') }}" class="nav-link rounded-4 {{ isset($active) && $active === 'dashboard' ? 'active' : '' }}" aria-current="page">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('dashboard.orders') }}" class="nav-link rounded-4 {{ isset($active) && $active === 'orders' ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> My Orders
        </a>
        <a href="{{ route('dashboard.messages') }}" class="nav-link rounded-4 {{ isset($active) && $active === 'messages' ? 'active' : '' }}">
            <i class="bi bi-chat-dots"></i> Messages
        </a>
        <a href="{{ route('dashboard.notifications') }}" class="nav-link rounded-4 {{ isset($active) && $active === 'notifications' ? 'active' : '' }}">
            <i class="bi bi-bell"></i> Notifications
        </a>
        <a href="{{ route('dashboard.profile') }}" class="nav-link rounded-4 {{ isset($active) && $active === 'profile' ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Profile
        </a>
        <a href="#" class="nav-link rounded-4 disabled" tabindex="-1" aria-disabled="true">
            <i class="bi bi-gear"></i> Settings
        </a>
    </nav>
</aside>
