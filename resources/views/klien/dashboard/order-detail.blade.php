@extends('layouts.dashboard')

@section('content')
<div class="dashboard-page">
    <div class="mb-4">
        <a href="{{ route('dashboard.home') }}" class="text-decoration-none text-primary"><i class="bi bi-chevron-left"></i> Back to orders</a>
    </div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card rounded-4 shadow-sm p-4 bg-white">
                <div class="d-flex align-items-start justify-content-between gap-3 mb-4 flex-column flex-md-row">
                    <div>
                        <p class="text-muted mb-2">Order #{{ $order['id'] }}</p>
                        <h2 class="h4 fw-bold mb-1">{{ $order['title'] }}</h2>
                        <p class="text-muted mb-0">Seller: <span class="fw-semibold">{{ $order['seller'] }}</span></p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-warning text-dark mb-2">{{ $order['status'] }}</span>
                        <p class="text-muted mb-0">Placed on {{ $order['date'] }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="h6 fw-semibold mb-3">Progress Timeline</h3>
                    <ul class="timeline-list list-unstyled mb-0">
                        @foreach($order['progress'] as $step)
                            <li class="timeline-item">
                                <span class="timeline-marker"></span>
                                <div>
                                    <p class="mb-1 fw-semibold">{{ $step }}</p>
                                    <small class="text-muted">Updated recently</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <div class="p-4 rounded-4 bg-primary bg-opacity-10 border border-primary border-opacity-10">
                            <h3 class="h6 fw-semibold">Chat with seller</h3>
                            <p class="text-muted mb-3">Sampaikan pertanyaan atau revisi langsung ke freelancer.</p>
                            <a href="{{ route('dashboard.messages') }}" class="btn btn-primary rounded-pill px-4">Open chat</a>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h3 class="h6 fw-semibold">Service detail</h3>
                        <div class="d-flex p-4 rounded-4 bg-white border border-1 border-light shadow-sm">
                                <div class="d-flex gap-3 align-items-center shadow-sm p-3 rounded-4 border border-1 border-light-secondary" style="background-color: #f8f9fa; width: 400px height: 80px;">
                                    <img src="{{ $order['image'] }}" alt="Service image" class="rounded-4 service-preview" style="width: 200px; height: 200px; object-fit: cover;"/>

                                    <div class="d-flex flex-column" style="flex: 1; min-width: 0;">
                                        <p class="mb-1">{{ $order['title'] }}</p>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $order['seller'] }}</span>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card rounded-4 shadow-sm p-4 bg-white">
                <h3 class="h6 fw-semibold mb-3">Payment Information</h3>
                <div class="mb-3">
                    <p class="mb-1 text-muted">Method</p>
                    <p class="fw-semibold">{{ $order['payment']['method'] }}</p>
                </div>
                <div class="mb-3">
                    <p class="mb-1 text-muted">Amount</p>
                    <p class="fw-semibold">{{ $order['payment']['amount'] }}</p>
                </div>
                <div class="mb-3">
                    <p class="mb-1 text-muted">Status</p>
                    <span class="badge bg-success">{{ $order['payment']['status'] }}</span>
                </div>
                <hr>
                <div class="order-summary">
                    <h3 class="h6 fw-semibold mb-3">Order Summary</h3>
                    @foreach($order['summary'] as $label => $value)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">{{ $label }}</span>
                            <span class="fw-semibold">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>

                @if($order['can_review'])
                    <div class="mt-4">
                        <a href="{{ $order['review_route'] }}" class="btn btn-success w-100 rounded-pill">Beri Review</a>
                    </div>
                @elseif(!empty($order['review_id']))
                    <div class="mt-4">
                        <a href="{{ route('review.show', $order['review_id']) }}" class="btn btn-outline-secondary w-100 rounded-pill">Lihat Review</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
