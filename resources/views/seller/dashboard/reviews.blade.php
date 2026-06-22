@extends('layouts.seller-dashboard')

@section('content')
<div class="dashboard-page">
    <section class="dashboard-hero mb-4">
        <div class="hero-copy p-4 rounded-4 shadow-sm bg-white">
            <h2 class="fw-bold mb-1">Reviews</h2>
            <p class="text-muted mb-0">Lihat feedback terbaru untuk layanan Anda dan perbaiki reputasi marketplace.</p>
        </div>
    </section>

    <div class="card rounded-4 shadow-sm bg-white p-4">
        <div class="row g-3">
            @foreach($reviews as $review)
                <div class="col-12">
                    <div class="border rounded-4 p-4 mb-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <h5 class="mb-1">{{ $review['service'] }}</h5>
                                <small class="text-muted">{{ $review['client'] }}</small>
                            </div>
                            <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary py-2 px-3">{{ $review['rating'] }} ★</span>
                        </div>
                        <p class="text-muted mb-2">{{ $review['text'] }}</p>
                        <small class="text-muted">{{ $review['date'] }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
