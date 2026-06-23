@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="row g-4 justify-content-center">
        <div class="col-lg-6">
            <!-- Failure Card -->
            <div class="card rounded-4 shadow-sm p-5 text-center">
                <div class="mb-4">
                    <div class="mx-auto mb-3" style="width: 80px; height: 80px; background-color: #f8d7da; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-x-circle-fill text-danger" style="font-size: 3rem;"></i>
                    </div>
                </div>

                <h1 class="h3 fw-bold mb-2">Pembayaran Gagal</h1>
                <p class="text-muted mb-4">Pembayaran Anda tidak dapat diproses. Silakan coba lagi atau gunakan metode pembayaran lain.</p>

                <!-- Order Info -->
                <div class="bg-light p-4 rounded-4 mb-4">
                    <div class="text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Nomor Pesanan</span>
                            <span class="fw-bold text-monospace">{{ $order->order_code }}</span>
                        </div>
                        @if($order->payment)
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
                                <span class="text-muted">Jumlah</span>
                                <span class="fw-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Service Summary -->
                <div class="mb-4">
                    <div class="bg-white p-4 rounded-4 border">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $order->service->primary_image ?? asset('images/no-image.png') }}"
                                 alt="{{ $order->service->title }}"
                                 class="rounded-2"
                                 style="width: 60px; height: 60px; object-fit: cover;" />
                            <div class="text-start flex-grow-1">
                                <p class="mb-1 fw-semibold">{{ $order->service->title }}</p>
                                <p class="mb-0 text-muted small">By {{ $order->service->user->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3 flex-column flex-sm-row">
                    <a href="{{ route('payment.show', $order->id) }}" class="btn btn-primary btn-lg rounded-pill flex-grow-1">
                        <i class="bi bi-arrow-repeat"></i> Coba Lagi
                    </a>
                    <a href="{{ route('checkout.create', $order->service_id) }}" class="btn btn-outline-secondary btn-lg rounded-pill flex-grow-1">
                        <i class="bi bi-arrow-left"></i> Kembali ke Checkout
                    </a>
                </div>

                <!-- Help Section -->
                <div class="mt-4 p-4 bg-light rounded-4">
                    <h5 class="h6 fw-semibold mb-2">Mengalami Masalah?</h5>
                    <p class="text-muted small mb-2">Jika terus mengalami kesulitan, silakan coba:</p>
                    <ul class="text-start text-muted small mb-0">
                        <li>Gunakan metode pembayaran lain</li>
                        <li>Periksa saldo/limit kartu Anda</li>
                        <li>Hubungi customer support kami</li>
                    </ul>
                </div>

                <!-- Back to Dashboard -->
                <div class="mt-4">
                    <a href="{{ route('dashboard.orders') }}" class="text-decoration-none text-muted small">
                        <i class="bi bi-house"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
