@extends('layouts.dashboard')

@section('content')
<div class="dashboard-page">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">My Orders</h2>
            <p class="text-muted">Semua pesanan Anda dikelompokkan menurut status pekerjaan.</p>
        </div>
        <div class="btn-group rounded-pill overflow-hidden shadow-sm" role="group" aria-label="Order status tabs">
            <button type="button" class="btn btn-outline-secondary">Pending</button>
            <button type="button" class="btn btn-outline-secondary active">Diproses</button>
            <button type="button" class="btn btn-outline-secondary">Selesai</button>
            <button type="button" class="btn btn-outline-secondary">Dibatalkan</button>
        </div>
    </div>

    <div class="row g-3">
        @forelse($orders as $order)
            <div class="col-12 col-md-6 col-xl-4">
                @include('klien.dashboard.components.order-card', ['order' => $order, 'detailRoute' => route('dashboard.order.detail', ['id' => $order['id']])])
            </div>
        @empty
            <div class="col-12"><div class="text-muted">No orders found</div></div>
        @endforelse
    </div>
    @if(method_exists($orders, 'links'))
        <div class="mt-3">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
