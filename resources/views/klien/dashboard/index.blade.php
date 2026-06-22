@extends('layouts.dashboard')

@section('content')
<div class="dashboard-page">
    <section class="dashboard-hero mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-4 align-items-start">
            <div class="hero-copy p-4 rounded-4 shadow-sm bg-white">
                <span class="badge bg-primary bg-opacity-10 text-primary mb-3">Client Dashboard</span>
                <h2 class="text-primary fw-bold">Welcome back, Arif</h2>
                <p class="text-muted">Lihat ringkasan pesanan Anda, perkembangan proyek, dan komunikasi terbaru dalam satu workspace profesional.</p>
            </div>
            <div class="hero-spark p-4 rounded-4 shadow-sm bg-gradient">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <p class="text-scondary mb-1">Today’s activity</p>
                        <h3 class="mb-0">+12 updates</h3>
                    </div>
                    <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Premium</span>
                </div>
                <p class="text-scondary mb-0">Ikuti proyek Anda, temukan aktivitas terbaru, dan lanjutkan dialog dengan freelancer tanpa berpindah tab.</p>
            </div>
        </div>
    </section>

    <section class="dashboard-stats mb-4">
        <div class="row g-3">
            @foreach($stats as $stat)
                <div class="col-6 col-xl-3">
                    @include('klien.dashboard.components.stat-card', ['stat' => $stat])
                </div>
            @endforeach
        </div>
    </section>

    <section class="dashboard-section mb-4">
        <div class="section-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3">
            <div>
                <h3 class="mb-1">Recent Orders</h3>
                <p class="text-muted mb-0">Pantau status pesanan Anda yang paling baru.</p>
            </div>
            <a href="{{ route('dashboard.orders') }}" class="text-primary text-decoration-none">Lihat semua orders</a>
        </div>
        <div class="row g-3">
            @forelse($recentOrders as $order)
                <div class="col-12 col-md-4">
                    @include('klien.dashboard.components.order-card', ['order' => $order, 'detailRoute' => route('dashboard.order.detail', ['id' => $order['id']])])
                </div>
            @empty
                <div class="col-12">
                    <div class="text-muted">No recent orders</div>
                </div>
            @endforelse
        </div>
    </section>

    <div class="row g-3">
        <div class="col-lg-8">
            <section class="dashboard-section mb-4">
                <div class="section-header d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Recommended Services</h3>
                    <a href="#" class="text-primary text-decoration-none">Explore all</a>
                </div>
                <div class="row g-3">
                    @forelse($recommendedServices as $service)
                        <div class="col-12 col-sm-6">
                            <div class="card dashboard-service-card rounded-4 shadow-sm overflow-hidden service-card position-relative">
                                <img src="{{ $service['primary_image'] }}" alt="{{ $service['title'] }}" class="card-img-top service-thumb" />
                                <div class="card-body">
                                    <small class="text-primary fw-semibold">{{ $service['category'] }}</small>
                                    <h5 class="card-title mt-2 mb-2">{{ $service['title'] }}</h5>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="text-muted mb-0 small">{{ $service['seller'] }}</p>
                                        <span class="fw-semibold text-primary">{{ $service['price'] }}</span>
                                    </div>
                                    <p class="text-muted mb-3 small detail-indicator">Klik untuk melihat detail</p>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="{{ route('services.show', $service['id']) }}" class="btn btn-outline-primary rounded-pill flex-grow-1">View Detail</a>
                                        <a href="{{ route('checkout.create', $service['id']) }}" class="btn btn-primary rounded-pill flex-grow-1">Pesan Sekarang</a>
                                    </div>
                                    <a href="{{ route('services.show', $service['id']) }}" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-muted">No recommended services</div>
                        </div>
                    @endforelse
                </div>
                @if(method_exists($recommendedServices, 'links'))
                    <div class="mt-3">{{ $recommendedServices->links() }}</div>
                @endif
            </section>
        </div>

        <div class="col-lg-4">
            <section class="dashboard-section mb-4">
                <div class="section-header mb-3">
                    <h3 class="mb-0">Recent Activities</h3>
                </div>
                <div class="list-group dashboard-activity-list rounded-4 shadow-sm bg-white">
                    @foreach($recentActivities as $activity)
                        <div class="list-group-item border-0">
                            <p class="mb-1">{{ $activity['text'] }}</p>
                            <small class="text-muted">{{ $activity['time'] }}</small>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="dashboard-section">
                <div class="section-header mb-3">
                    <h3 class="mb-0">Quick Actions</h3>
                </div>
                <div class="row g-2">
                    @foreach($quickActions as $action)
                        <div class="col-6">
                            <a href="{{ $action['url'] }}" class="btn btn-outline-primary btn-action w-100 rounded-4 d-flex align-items-center gap-2">
                                <i class="bi {{ $action['icon'] }}"></i>
                                <span>{{ $action['label'] }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
