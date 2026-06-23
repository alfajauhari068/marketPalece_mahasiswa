@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="mb-4">
        <a href="{{ route('services.show', $service->id) }}" class="text-decoration-none text-primary">
            <i class="bi bi-chevron-left"></i> Kembali ke Detail Layanan
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card rounded-4 shadow-sm p-4">
                <span class="badge bg-primary bg-opacity-10 text-primary mb-3">Checkout</span>
                <h1 class="h3 fw-bold mb-3">Pesan layanan ini</h1>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <img src="{{ $service->primary_image ?? asset('images/no-image.png') }}"
                         alt="{{ $service->title }}"
                         class="rounded-4"
                         style="width: 110px; height: 110px; object-fit: cover;" />
                    <div>
                        <p class="text-muted mb-1">{{ $service->category?->name ?? 'Kategori' }}</p>
                        <h2 class="h5 fw-semibold mb-1">{{ $service->title }}</h2>
                        <p class="text-muted mb-0">By {{ $service->user?->name ?? 'Freelancer' }}</p>
                    </div>
                </div>

                <p class="text-muted mb-4">{{ $service->description }}</p>

                <div class="row row-cols-2 g-3 mb-4">
                    <div class="col">
                        <div class="p-3 rounded-4 bg-light">
                            <small class="text-muted">Harga</small>
                            <div class="fw-semibold">Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 rounded-4 bg-light">
                            <small class="text-muted">Seller</small>
                            <div class="fw-semibold">{{ $service->user?->name ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info rounded-4">
                    Halaman checkout ini menyiapkan ringkasan pesanan sebelum melanjutkan ke pembayaran.
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Total yang harus dibayar</div>
                        <div class="fs-4 fw-bold">Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}</div>
                    </div>
                    <button type="button" class="btn btn-primary btn-lg rounded-pill px-5">Lanjutkan ke Pembayaran</button>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card rounded-4 shadow-sm p-4">
                <h2 class="h6 fw-semibold mb-3">Ringkasan Pesanan</h2>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Layanan</span>
                        <span>{{ $service->title }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Harga</span>
                        <span>Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                <hr />

                <div class="d-flex justify-content-between fw-semibold">
                    <span>Total</span>
                    <span>Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
