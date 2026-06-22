@extends('layouts.seller-dashboard')

@section('content')
<div class="dashboard-page">
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card p-4 rounded-4 bg-white">
                <h6 class="text-muted">Total Revenue</h6>
                <h4 class="mb-0">{{ number_format($totalRevenue, 0, ',', '.') }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-4 rounded-4 bg-white">
                <h6 class="text-muted">Active Orders</h6>
                <h4 class="mb-0">{{ $activeOrders }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-4 rounded-4 bg-white">
                <h6 class="text-muted">Total Services</h6>
                <h4 class="mb-0">{{ $totalServices }}</h4>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-4 rounded-4 bg-white">
                <h6 class="text-muted">Average Rating</h6>
                <h4 class="mb-0">{{ number_format($averageRating, 1) }}</h4>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card p-4 rounded-4 bg-white">
                <h5>Recent Orders</h5>
                <div class="list-group mt-3">
                    @forelse($recentOrders as $order)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>#{{ $order->id }} {{ $order->service?->title }}</strong>
                                <div class="text-muted small">Buyer: {{ $order->buyer?->name }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-semibold">{{ number_format($order->total_price, 0, ',', '.') }}</div>
                                <small class="text-muted">{{ $order->status }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">No recent orders</div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card p-4 rounded-4 bg-white">
                <h5>Recent Reviews</h5>
                <div class="mt-3">
                    @forelse($recentReviews as $review)
                        <div class="mb-3">
                            <strong>{{ $review->reviewer?->name }}</strong>
                            <div class="text-muted small">Rating: {{ $review->rating }}</div>
                            <p class="mb-0 text-muted">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <div class="text-muted">No recent reviews</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
