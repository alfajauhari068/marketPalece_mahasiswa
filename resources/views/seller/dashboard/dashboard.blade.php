@extends('layouts.seller-dashboard')

@section('content')
<div class="dashboard-page">
    <section class="dashboard-hero mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-4 align-items-start">
            <div class="hero-copy p-4 rounded-4 shadow-sm bg-white">
                <span class="badge bg-primary bg-opacity-10 text-primary mb-3">Seller Dashboard</span>
                <h2 class="fw-bold">Welcome back, Sarah</h2>
                <p class="text-muted">Kelola layanan, pantau pesanan aktif, dan lihat performa penjualan Anda di satu tempat.</p>
            </div>
            <div class="hero-spark p-4 rounded-4 shadow-sm bg-gradient">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <p class="text-muted mb-1">Weekly momentum</p>
                        <h3 class="mb-0">+18% growth</h3>
                    </div>
                    <span class="badge bg-white text-primary py-2 px-3 rounded-pill">Seller</span>
                </div>
                <p class="text-white mb-0">Tetap responsif, terbitkan layanan baru, dan terus raih kepercayaan kampus lewat marketplace yang modern.</p>
            </div>
        </div>
    </section>

    <section class="dashboard-stats mb-4">
        <div class="row g-3">
            @foreach($stats as $stat)
                <div class="col-6 col-xl-3">
                    <div class="card rounded-4 shadow-sm p-4 h-100 bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h6 class="text-muted mb-1">{{ $stat['title'] }}</h6>
                                <h3 class="mb-0">{{ $stat['value'] }}</h3>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary p-3 rounded-4"><i class="bi {{ $stat['icon'] }} fs-5"></i></span>
                        </div>
                        <p class="text-muted small mb-0">{{ $stat['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <div class="row g-3">
        <div class="col-lg-8">
            <section class="dashboard-section mb-4">
                <div class="section-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3">
                    <div>
                        <h3 class="mb-1">Recent Orders</h3>
                        <p class="text-muted mb-0">Lihat status order aktif dan tugas yang mendekati deadline.</p>
                    </div>
                    <a href="{{ route('seller.orders.index') }}" class="text-primary text-decoration-none">View all orders</a>
                </div>
                <div class="row g-3">
                    @foreach($recentOrders as $order)
                        <div class="col-12 col-md-6">
                            <div class="card rounded-4 shadow-sm h-100 bg-white p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="mb-1">{{ $order['title'] }}</h5>
                                        <small class="text-muted">{{ $order['client'] }}</small>
                                    </div>
                                    <span class="badge rounded-pill bg-{{ $order['badge'] }} bg-opacity-10 text-{{ $order['badge'] }} py-2 px-3">{{ $order['status'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted mb-0 small">Due {{ $order['date'] }}</p>
                                    <p class="fw-semibold mb-0">{{ $order['price'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="dashboard-section mb-4">
                <div class="section-header d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Service Performance</h3>
                    <a href="{{ route('seller.services.index') }}" class="text-primary text-decoration-none">Manage services</a>
                </div>
                <div class="row g-3">
                    @foreach($performance as $item)
                        <div class="col-12 col-sm-4">
                            <div class="card rounded-4 shadow-sm h-100 p-4 bg-white">
                                <h6 class="text-muted">{{ $item['metric'] }}</h6>
                                <h4 class="mt-2 mb-1">{{ $item['value'] }}</h4>
                                <p class="text-success small mb-0">{{ $item['change'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="col-lg-4">
            <section class="dashboard-section mb-4">
                <div class="section-header d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Recent Reviews</h3>
                    <span class="text-muted small">Top feedback</span>
                </div>
                <div class="list-group dashboard-activity-list rounded-4 shadow-sm bg-white p-3">
                    @foreach($reviews as $review)
                        <div class="list-group-item border-0 p-3 rounded-4 mb-2 bg-white">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>{{ $review['author'] }}</strong>
                                <span class="badge bg-primary bg-opacity-10 text-primary">{{ $review['rating'] }} ★</span>
                            </div>
                            <p class="mb-2 text-muted">{{ $review['text'] }}</p>
                            <small class="text-muted">{{ $review['date'] }}</small>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="dashboard-section">
                <div class="section-header d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Earnings Overview</h3>
                    <a href="{{ route('seller.earnings.index') }}" class="text-primary text-decoration-none">View report</a>
                </div>
                <div class="card rounded-4 shadow-sm p-4 bg-white">
                    @foreach($earnings as $item)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <p class="mb-0 text-muted">{{ $item['month'] }}</p>
                            <p class="mb-0 fw-semibold">{{ $item['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
