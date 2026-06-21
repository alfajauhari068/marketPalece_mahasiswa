@extends('layouts.app')

@section('content')
<div class="py-5">
    <div class="container">
        <div class="bg-white rounded-4 shadow-sm p-5">
            <h1 class="h3 fw-bold mb-3">Seller Dashboard</h1>
            <p class="text-muted mb-4">Selamat datang di dashboard penjual. Konten ini akan ditampilkan untuk pengguna dengan peran seller.</p>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-4 rounded-4 border border-1 border-light">
                        <h2 class="h5 fw-semibold">Manage Services</h2>
                        <p class="text-muted mb-0">Kelola jasa Anda, tambahkan paket, dan pantau order masuk.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded-4 border border-1 border-light">
                        <h2 class="h5 fw-semibold">Active Orders</h2>
                        <p class="text-muted mb-0">Lihat status pesanan klien dan permintaan revisi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
