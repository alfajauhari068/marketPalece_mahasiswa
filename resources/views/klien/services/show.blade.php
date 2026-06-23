@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="mb-4">
        <a href="{{ route('dashboard.home') }}" 
        class="text-decoration-none text-primary">
            <i class="bi bi-chevron-left"></i> Kembali ke Marketplace
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card rounded-4 shadow-sm overflow-hidden">
                <img id="service-main-image"
                     src="{{ $service->primary_image ?? asset('images/no-image.png') }}"
                     alt="{{ $service->title }}"
                     class="w-100"
                     style="aspect-ratio: 4/3; object-fit: cover;" />

                @if($service->images->isNotEmpty())
                    <div class="d-flex flex-wrap gap-2 p-3 bg-white">
                        @foreach($service->images as $image)
                            <button type="button"
                                    class="gallery-thumb btn p-0 border rounded-4 {{ $loop->first ? 'active' : '' }}"
                                    data-url="{{ $image->url }}"
                                    aria-label="Pilih gambar {{ $loop->iteration }}">
                                <img src="{{ $image->url }}"
                                     alt="Gallery image {{ $loop->iteration }}"
                                     class="img-fluid rounded-4"
                                     style="width: 96px; height: 96px; object-fit: cover;" />
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card rounded-4 shadow-sm p-4">
                <span class="badge bg-primary bg-opacity-10 text-primary mb-3">{{ $service->category?->name ?? 'Kategori' }}</span>
                <h1 class="h3 fw-bold mb-2">{{ $service->title }}</h1>
                <p class="text-muted mb-4">Dibuat oleh <strong>{{ $service->user?->name ?? 'Freelancer' }}</strong></p>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <div class="fs-4 fw-semibold text-primary">Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}</div>
                        <small class="text-muted">Harga mulai</small>
                    </div>
                    <a href="{{ route('checkout.create', $service->id) }}" class="btn btn-primary rounded-pill px-4">Pesan Sekarang</a>
                </div>

                <div class="mb-4">
                    <h2 class="h6 fw-semibold mb-2">Deskripsi Layanan</h2>
                    <p class="text-muted mb-0">{{ $service->description }}</p>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 rounded-4 bg-light">
                            <small class="text-uppercase text-muted">Seller</small>
                            <div class="fw-semibold">{{ $service->user?->name ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-4 bg-light">
                            <small class="text-uppercase text-muted">Status</small>
                            <div class="fw-semibold text-capitalize">{{ $service->status }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainImage = document.getElementById('service-main-image');
    document.querySelectorAll('.gallery-thumb').forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            mainImage.src = this.dataset.url;
            document.querySelectorAll('.gallery-thumb.active').forEach(function (activeThumb) {
                activeThumb.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
});
</script>
@endsection
