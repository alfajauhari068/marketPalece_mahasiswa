@extends('layouts.seller-dashboard')

@section('content')
<div class="dashboard-page">
    <section class="dashboard-hero mb-4">
        <div class="hero-copy p-4 rounded-4 shadow-sm bg-white">
            <h2 class="fw-bold mb-1">Earnings</h2>
            <p class="text-muted mb-0">Ringkasan penghasilan Anda dari order dan layanan terlaris.</p>
        </div>
    </section>

    <div class="row g-3">
        <div class="col-lg-5">
            <div class="card rounded-4 shadow-sm bg-white p-4 h-100">
                <h4 class="mb-3">Total Earnings</h4>
                <p class="display-6 fw-bold">{{ $total }}</p>
                <p class="text-muted">Pendapatan bersih dari semua order dalam 30 hari terakhir.</p>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card rounded-4 shadow-sm bg-white p-4 h-100">
                <h4 class="mb-3">Monthly breakdown</h4>
                <div class="row g-3">
                    @foreach($history as $item)
                        <div class="col-6">
                            <div class="border rounded-4 p-3">
                                <p class="text-muted mb-1">{{ $item['month'] }}</p>
                                <p class="fw-semibold mb-0">{{ $item['value'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
