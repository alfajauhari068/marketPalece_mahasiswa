@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="mb-4">
        <a href="{{ route('dashboard.orders') }}" class="text-decoration-none text-primary">
            <i class="bi bi-chevron-left"></i> Kembali ke Pesanan
        </a>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-lg-8">
            <!-- Invoice Card -->
            <div class="card rounded-4 shadow-sm">
                <!-- Header -->
                <div class="card-header bg-primary text-white rounded-top-4 p-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="h4 fw-bold mb-0">INVOICE</h2>
                            <p class="text-white-50 mb-0">{{ config('app.name', 'Marketplace Mahasiswa') }}</p>
                        </div>
                        <div class="col-auto text-end">
                            <p class="mb-1"><strong>Invoice #{{ $order->order_code }}</strong></p>
                            <p class="mb-0 small">Tanggal: {{ $order->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Invoice Details Grid -->
                    <div class="row mb-4">
                        <!-- From/Seller Info -->
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold mb-2">Dari (Penjual):</h6>
                            <div class="p-3 bg-light rounded-3">
                                <p class="fw-semibold mb-1">{{ $order->seller->name }}</p>
                                <p class="text-muted small mb-0">{{ $order->seller->email }}</p>
                                @if($order->seller->profile)
                                    <p class="text-muted small mb-0">Rating: {{ $order->seller->profile->rating_avg ?? 'N/A' }}/5</p>
                                @endif
                            </div>
                        </div>

                        <!-- To/Buyer Info -->
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold mb-2">Kepada (Pembeli):</h6>
                            <div class="p-3 bg-light rounded-3">
                                <p class="fw-semibold mb-1">{{ $order->buyer->name }}</p>
                                <p class="text-muted small mb-0">{{ $order->buyer->email }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Order Information -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">ID Pesanan:</span>
                                <strong>{{ $order->id }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tanggal Pesanan:</span>
                                <strong>{{ $order->created_at->format('d M Y H:i') }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Status Pesanan:</span>
                                <span class="badge {{ $order->status === 'pending' ? 'bg-warning' : ($order->status === 'diproses' ? 'bg-info' : ($order->status === 'selesai' ? 'bg-success' : 'bg-danger')) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Nomor Invoice:</span>
                                <strong class="text-monospace">{{ $order->order_code }}</strong>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Service Details -->
                    <h6 class="fw-bold mb-3">Detail Layanan:</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-borderless">
                            <thead class="table-light">
                                <tr>
                                    <th>Layanan</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $order->service->primary_image ?? asset('images/no-image.png') }}"
                                                 alt="{{ $order->service->title }}"
                                                 class="rounded-2"
                                                 style="width: 50px; height: 50px; object-fit: cover;" />
                                            <div>
                                                <p class="fw-semibold mb-0">{{ $order->service->title }}</p>
                                                <p class="text-muted small mb-0">{{ $order->service->category->name ?? 'Kategori' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $order->quantity }}</td>
                                    <td class="text-end">Rp {{ number_format($order->service->price, 0, ',', '.') }}</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Order Notes -->
                    @if($order->orderDetail && $order->orderDetail->note)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Catatan Pesanan:</h6>
                            <div class="p-3 bg-light rounded-3">
                                <p class="mb-0">{{ $order->orderDetail->note }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Summary -->
                    <div class="row justify-content-end mb-4">
                        <div class="col-md-5">
                            <div class="p-3 bg-light rounded-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Biaya Layanan:</span>
                                    <strong>Rp 0</strong>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fs-5">
                                    <span class="fw-bold">Total:</span>
                                    <span class="fw-bold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    @if($order->payment)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Informasi Pembayaran:</h6>
                            <div class="p-3 bg-light rounded-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Metode Pembayaran:</span>
                                    <strong>
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
                                    </strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Status Pembayaran:</span>
                                    <span class="badge {{ $order->payment->status === 'paid' ? 'bg-success' : ($order->payment->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($order->payment->status) }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Nomor Transaksi:</span>
                                    <strong class="text-monospace">{{ $order->payment->transaction_id }}</strong>
                                </div>
                                @if($order->payment->paid_at)
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Tanggal Pembayaran:</span>
                                        <strong>{{ $order->payment->paid_at->format('d M Y H:i') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Footer Note -->
                    <div class="alert alert-info alert-sm rounded-3 mb-0">
                        <small><i class="bi bi-info-circle"></i> Invoice ini adalah bukti transaksi resmi. Simpan invoice ini untuk keperluan Anda.</small>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-light rounded-bottom-4 p-4 text-center">
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <a href="{{ route('invoice.download', $order->id) }}" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-download"></i> Download PDF
                        </a>
                        <a href="{{ route('dashboard.orders') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-house"></i> Ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
