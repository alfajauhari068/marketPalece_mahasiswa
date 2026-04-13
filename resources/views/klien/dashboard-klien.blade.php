@extends('layouts.app')

@section('content')

<div class="hero-section mb-5">
    <div class="row g-0 align-items-center">
        <div class="col-md-6 p-5">
            <h1 class="fw-bold">Dari Mahasiswa, Untuk Mahasiswa</h1>
            <p class="text-muted">Temukan jasa profesional dari teman kampusmu.</p>
            <a href="#" class="btn btn-primary px-4">Jelajahi Jasa</a>
        </div>
        <div class="col-md-6">
            <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" 
                 class="img-fluid w-100" style="object-fit: cover; height: 300px;" alt="Hero Image">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 mb-4">
        <div class="bg-white p-4 rounded shadow-sm">
            <p class="sidebar-title">Kategori</p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="c1">
                <label class="form-check-label" for="c1">Desain Grafis</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="c2">
                <label class="form-check-label" for="c2">Pemrograman</label>
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="c3">
                <label class="form-check-label" for="c3">Penulisan</label>
            </div>

            <p class="sidebar-title">Rating</p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="r1">
                <label class="form-check-label" for="r1">4 bintang ke atas</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="r2">
                <label class="form-check-label" for="r2">3 bintang ke atas</label>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="row g-4">
            <div class="col-md-6 col-xl-4">
                <div class="card card-service shadow-sm h-100">
                    <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?auto=format&fit=crop&w=500&q=60" class="card-img-top rounded-top-4" alt="Service 1">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">Desain Logo Profesional</h6>
                        <p class="text-muted small mb-1">Budi Santoso</p>
                        <div class="mb-2">
                            <span class="rating-star">★</span> <small class="text-muted">4.9</small>
                        </div>
                        <p class="price-text mb-0">Rp 150.000</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="card card-service shadow-sm h-100">
                    <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=500&q=60" class="card-img-top rounded-top-4" alt="Service 2">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">Web Development React</h6>
                        <p class="text-muted small mb-1">Siti Aminah</p>
                        <div class="mb-2">
                            <span class="rating-star">★</span> <small class="text-muted">5.0</small>
                        </div>
                        <p class="price-text mb-0">Rp 500.000</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-4">
                <div class="card card-service shadow-sm h-100">
                    <img src="https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=500&q=60" class="card-img-top rounded-top-4" alt="Service 3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">Penulisan Artikel SEO</h6>
                        <p class="text-muted small mb-1">Rizky Pratama</p>
                        <div class="mb-2">
                            <span class="rating-star">★</span> <small class="text-muted">4.8</small>
                        </div>
                        <p class="price-text mb-0">Rp 75.000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection