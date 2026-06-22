@extends('layouts.seller-dashboard')

@section('content')
<div class="dashboard-page">
    <section class="dashboard-hero mb-4">
        <div class="hero-copy p-4 rounded-4 shadow-sm bg-white">
            <h2 class="fw-bold mb-1">Orders</h2>
            <p class="text-muted mb-0">Telusuri pesanan aktif, kelola status, dan tetap responsif terhadap buyer.</p>
        </div>
    </section>

    <div class="card rounded-4 shadow-sm bg-white p-4">
        <div class="table-responsive">
            <table class="table table-borderless align-middle mb-0">
                <thead>
                    <tr class="text-muted small text-uppercase">
                        <th>Order</th>
                        <th>Client</th>
                        <th>Due</th>
                        <th>Status</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <h6 class="mb-1">{{ $order['title'] }}</h6>
                                <small class="text-muted">{{ $order['service'] }}</small>
                            </td>
                            <td>{{ $order['client'] }}</td>
                            <td>{{ $order['date'] }}</td>
                            <td><span class="badge rounded-pill bg-{{ $order['badge'] }} bg-opacity-10 text-{{ $order['badge'] }} py-2 px-3">{{ $order['status'] }}</span></td>
                            <td class="text-end fw-semibold">{{ $order['total'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
