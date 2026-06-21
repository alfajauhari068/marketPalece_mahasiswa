<nav class="dashboard-bottomnav d-lg-none" aria-label="Bottom navigation">
    <a href="{{ route('dashboard.home') }}" class="bottomnav-item {{ isset($active) && $active === 'dashboard' ? 'active' : '' }}" aria-label="Dashboard">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('dashboard.orders') }}" class="bottomnav-item {{ isset($active) && $active === 'orders' ? 'active' : '' }}" aria-label="Orders">
        <i class="bi bi-bag-check"></i>
        <span>Orders</span>
    </a>
    <a href="{{ route('dashboard.messages') }}" class="bottomnav-item {{ isset($active) && $active === 'messages' ? 'active' : '' }}" aria-label="Messages">
        <i class="bi bi-chat-dots"></i>
        <span>Chat</span>
    </a>
    <a href="{{ route('dashboard.notifications') }}" class="bottomnav-item {{ isset($active) && $active === 'notifications' ? 'active' : '' }}" aria-label="Notifications">
        <i class="bi bi-bell"></i>
        <span>Alerts</span>
    </a>
</nav>
