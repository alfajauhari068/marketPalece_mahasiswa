@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="row g-4 justify-content-center">
        <div class="col-lg-6">
            <!-- Success Card -->
            <div class="card rounded-4 shadow-sm p-5 text-center">
                <div class="mb-4">
                    <div class="mx-auto mb-3" style="width: 80px; height: 80px; background-color: #d4edda; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                    </div>
                </div>

                <h1 class="h3 fw-bold mb-2">Pembayaran Berhasil!</h1>
                <p class="text-muted mb-4">Terima kasih telah melakukan pembayaran. Pesanan Anda sedang diproses oleh penjual.</p>

                <!-- Transaction Details -->
                <div class="bg-light p-4 rounded-4 mb-4">
                    <div class="text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Nomor Transaksi</span>
                            <span class="fw-bold text-monospace">{{ $order->payment->transaction_id }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Nomor Pesanan</span>
                            <span class="fw-bold text-monospace">{{ $order->order_code }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Metode Pembayaran</span>
                            <span class="fw-semibold">
                                @switch($order->payment->method)
                                    @case('qris')
                                        <i class="bi bi-qr-code"></i> QRIS
                                        @break
                                    @case('bank_transfer')
                                        <i class="bi bi-bank"></i> Transfer Bank
                                        @break
                                    @case('e_wallet')
                                        <i class="bi bi-wallet2"></i> E-wallet
                                        @break
                                    @default
                                        {{ ucfirst(str_replace('_', ' ', $order->payment->method)) }}
                                @endswitch
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Tanggal Pembayaran</span>
                            <span class="fw-semibold">{{ $order->payment->paid_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="mb-4">
                    <h3 class="h6 fw-semibold mb-3 text-start">Ringkasan Pesanan</h3>
                    <div class="bg-white p-4 rounded-4 border">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $order->service->primary_image ?? asset('images/no-image.png') }}"
                                 alt="{{ $order->service->title }}"
                                 class="rounded-2"
                                 style="width: 60px; height: 60px; object-fit: cover;" />
                            <div class="text-start flex-grow-1">
                                <p class="mb-1 fw-semibold">{{ $order->service->title }}</p>
                                <p class="mb-0 text-muted small">By {{ $order->service->user->name }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="text-start">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Harga × Jumlah</span>
                                <span>Rp {{ number_format($order->service->price, 0, ',', '.') }} × {{ $order->quantity }}</span>
                            </div>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total Pembayaran</span>
                                <span class="text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3">
                    <a href="{{ route('invoice.show', $order->id) }}" class="btn btn-outline-primary btn-lg rounded-pill flex-grow-1">
                        <i class="bi bi-file-pdf"></i> Lihat Invoice
                    </a>
                    <a href="{{ route('dashboard.orders') }}" class="btn btn-primary btn-lg rounded-pill flex-grow-1">
                        <i class="bi bi-house"></i> Ke Dashboard
                    </a>
                </div>

                <!-- Additional Info -->
                <div class="alert alert-info alert-sm rounded-3 mt-4 mb-0">
                    <small><i class="bi bi-info-circle"></i> Penjual akan segera memproses pesanan Anda. Anda akan menerima notifikasi saat progres update.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
