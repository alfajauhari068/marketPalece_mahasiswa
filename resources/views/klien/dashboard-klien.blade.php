@extends('layouts.app')

@section('content')

<div class="hero-section py-5 mb-5 rounded-4 shadow-sm">
    <div class="row gy-5 align-items-center">
        <div class="col-lg-6">
            <div class="px-4 py-5">
                <span class="badge bg-primary rounded-pill mb-3">Marketplace Jasa Mahasiswa</span>
                <h1 class="display-5 fw-bold">Temukan Freelancer Kampus dengan Kualitas Profesional</h1>
                <p class="lead text-muted">Platform internal kampus untuk menemukan jasa mahasiswa, membangun reputasi, dan menyelesaikan pekerjaan secara profesional.</p>
                <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                    <a href="#featured-services" class="btn btn-primary btn-lg rounded-pill px-5">Browse Services</a>
                    <a href="#" class="btn btn-outline-secondary btn-lg rounded-pill px-5">Become Seller</a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="position-relative text-center">
                <div class="rounded-4 bg-glass p-4 shadow-lg">
                    <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=900&q=80" class="img-fluid rounded-4" alt="Marketplace hero illustration">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5 text-center">
    <div class="col-sm-6 col-xl-3">
        <div class="p-4 rounded-4 bg-white shadow-sm h-100">
            <h2 class="display-6 mb-1">1.2K+</h2>
            <p class="text-muted mb-0">Total Services</p>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="p-4 rounded-4 bg-white shadow-sm h-100">
            <h2 class="display-6 mb-1">850+</h2>
            <p class="text-muted mb-0">Total Freelancers</p>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="p-4 rounded-4 bg-white shadow-sm h-100">
            <h2 class="display-6 mb-1">3.5K+</h2>
            <p class="text-muted mb-0">Completed Orders</p>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="p-4 rounded-4 bg-white shadow-sm h-100">
            <h2 class="display-6 mb-1">4.9</h2>
            <p class="text-muted mb-0">Average Rating</p>
        </div>
    </div>
</div>

<section id="categories" class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="h3 fw-bold">Kategori Populer</h2>
            <p class="text-muted">Temukan jasa berdasarkan kategori yang paling dicari mahasiswa.</p>
        </div>
        <a href="#" class="text-primary text-decoration-none">Lihat semua kategori</a>
    </div>

    <div class="row g-3">
        @foreach(['Design','Programming','Writing','Translation','Video Editing','Marketing','Photography','Other'] as $category)
            <div class="col-6 col-md-3">
                <div class="p-4 rounded-4 bg-white shadow-sm h-100 category-card">
                    <div class="mb-3 icon-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center rounded-circle" style="width:48px;height:48px;">
                        <i class="bi bi-grid-3x3-gap fs-5"></i>
                    </div>
                    <h6 class="mb-1 fw-semibold">{{ $category }}</h6>
                    <p class="text-muted small mb-0">Mulai dari Rp 50.000</p>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="featured-services" class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="h3 fw-bold">Featured Services</h2>
            <p class="text-muted">Layanan terbaik dengan reputasi tinggi dan review positif.</p>
        </div>
        <a href="#" class="text-primary text-decoration-none">Lihat semua layanan</a>
    </div>

    <div class="row g-4">
        @foreach([[
            'image' => 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?auto=format&fit=crop&w=700&q=80',
            'title' => 'Brand Identity Design',
            'seller' => 'Nina Rahma',
            'rating' => '4.9',
            'price' => 'Rp 180.000',
            'category' => 'Design'
        ], [
            'image' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=700&q=80',
            'title' => 'Fullstack Web Development',
            'seller' => 'Rizal Firmansyah',
            'rating' => '5.0',
            'price' => 'Rp 650.000',
            'category' => 'Programming'
        ], [
            'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=700&q=80',
            'title' => 'SEO Blog Writing',
            'seller' => 'Maya Sari',
            'rating' => '4.8',
            'price' => 'Rp 120.000',
            'category' => 'Writing'
        ]] as $service)
            <div class="col-md-6 col-xl-4">
                <div class="card rounded-4 shadow-sm h-100 service-card overflow-hidden">
                    <img src="{{ $service['image'] }}" alt="{{ $service['title'] }}" class="card-img-top" style="height:240px; object-fit:cover;">
                    <div class="card-body">
                        <span class="badge bg-secondary bg-opacity-10 text-secondary mb-3">{{ $service['category'] }}</span>
                        <h5 class="card-title fw-semibold">{{ $service['title'] }}</h5>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <p class="mb-1 text-muted small">{{ $service['seller'] }}</p>
                                <div class="d-flex align-items-center gap-1 text-warning small">
                                    <i class="bi bi-star-fill"></i>
                                    <span>{{ $service['rating'] }}</span>
                                </div>
                            </div>
                            <div class="fw-bold text-primary">{{ $service['price'] }}</div>
                        </div>
                        <a href="#" class="btn btn-outline-primary w-100 rounded-pill">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="how-it-works" class="mb-5">
    <div class="rounded-4 p-4 bg-white shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 fw-bold mb-1">Cara Kerja</h2>
                <p class="text-muted mb-0">Proses cepat dan jelas untuk memesan jasa mahasiswa.</p>
            </div>
        </div>
        <div class="row g-4 text-center">
            @foreach(['Browse Services','Select Service','Place Order','Seller Works','Complete Order','Review'] as $step)
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="p-4 rounded-4 border border-1 border-light bg-glass h-100">
                        <div class="mb-3 text-primary fs-4">✓</div>
                        <h6 class="fw-semibold">{{ $step }}</h6>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="testimonials" class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="h3 fw-bold">What Students Say</h2>
            <p class="text-muted">Testimoni pelanggan yang puas dengan layanan mahasiswa.</p>
        </div>
    </div>
    <div class="row g-4">
        @foreach([[
            'name' => 'Aditya',
            'role' => 'Entrepreneur',
            'rating' => '5.0',
            'text' => 'Layanan cepat dan hasilnya sangat profesional. Sangat mudah bekerja sama dengan freelancer kampus.'
        ], [
            'name' => 'Nina',
            'role' => 'Mahasiswi',
            'rating' => '4.8',
            'text' => 'Desainnya rapi dan komunikasinya jelas. Sangat membantu untuk tugas kampus saya.'
        ], [
            'name' => 'Rafi',
            'role' => 'Startup Founder',
            'rating' => '4.9',
            'text' => 'Sangat puas dengan hasilnya. Platformnya profesional dan mudah digunakan.'
        ]] as $testimonial)
            <div class="col-md-4">
                <div class="p-4 rounded-4 bg-white shadow-sm h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="avatar rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width:50px;height:50px; font-size:1.2rem;">
                            {{ strtoupper(substr($testimonial['name'], 0, 1)) }}
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $testimonial['name'] }}</h6>
                            <small class="text-muted">{{ $testimonial['role'] }}</small>
                        </div>
                    </div>
                    <div class="mb-3 text-warning small">
                        <i class="bi bi-star-fill"></i> {{ $testimonial['rating'] }}
                    </div>
                    <p class="text-muted mb-0">"{{ $testimonial['text'] }}"</p>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection