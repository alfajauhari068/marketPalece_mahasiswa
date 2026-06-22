@extends('layouts.seller-dashboard')

@section('content')
<div class="card p-4 rounded-4 bg-white">
    <h3>Orders</h3>
    <div class="table-responsive mt-3">
        <table class="table">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Client</th>
                    <th>Status</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td><a href="{{ route('seller.orders.show', $order) }}">#{{ $order->id }} {{ $order->service?->title }}</a></td>
                        <td>{{ $order->buyer?->name }}</td>
                        <td>{{ $order->status }}</td>
                        <td class="text-end">{{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $orders->links() }}</div>
</div>
@endsection
