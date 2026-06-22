@extends('layouts.seller-dashboard')

@section('content')
<div class="dashboard-page">
    <section class="dashboard-hero mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
            <div class="hero-copy p-4 rounded-4 shadow-sm bg-white">
                <h2 class="fw-bold mb-1">My Services</h2>
                <p class="text-muted mb-0">Kelola layanan Anda dan pantau status setiap penawaran.</p>
            </div>
            <div>
                <a href="#" class="btn btn-primary rounded-pill px-4">Create Service</a>
            </div>
        </div>
    </section>

    <div class="card rounded-4 shadow-sm bg-white p-4">
        <div class="row g-3 align-items-center mb-4">
            <div class="col-12 col-md-6">
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-white border-1"><i class="bi bi-search"></i></span>
                    <input type="search" class="form-control" placeholder="Search services" aria-label="Search services">
                </div>
            </div>
            <div class="col-12 col-md-6 text-md-end">
                <select class="form-select form-select-sm w-auto d-inline-block">
                    <option value="">All categories</option>
                    <option>AUDIO</option>
                    <option>Design</option>
                    <option>Marketing</option>
                </select>
            </div>
        </div>

        <div class="row g-3">
            @foreach($services as $service)
                <div class="col-12 col-md-6">
                    <div class="card rounded-4 shadow-sm h-100 bg-white p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-semibold mb-1">{{ $service['title'] }}</h5>
                                <small class="text-muted">{{ $service['category'] }}</small>
                            </div>
                            <span class="badge rounded-pill bg-{{ $service['status'] === 'Live' ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $service['status'] === 'Live' ? 'success' : 'secondary' }} py-2 px-3">{{ $service['status'] }}</span>
                        </div>
                        <p class="text-muted mb-3">{{ $service['reviews'] }} reviews</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">{{ $service['price'] }}</span>
                            <a href="#" class="text-primary text-decoration-none">Edit</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
