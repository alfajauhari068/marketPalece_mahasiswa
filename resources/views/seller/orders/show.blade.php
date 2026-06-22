@extends('layouts.seller-dashboard')

@section('content')
<div class="card p-4 rounded-4 bg-white">
    <h3>Order #{{ $order->id }}</h3>
    <div class="mt-3">
        <p><strong>Service:</strong> {{ $order->service?->title }}</p>
        <p><strong>Buyer:</strong> {{ $order->buyer?->name }}</p>
        <p><strong>Status:</strong> {{ $order->status }}</p>
        <p><strong>Total:</strong> {{ number_format($order->total_price, 0, ',', '.') }}</p>
        <p><strong>Payment:</strong> {{ $order->payment?->status ?? 'N/A' }}</p>
    </div>
</div>
@endsection
