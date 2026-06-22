@extends('layouts.seller-dashboard')

@section('content')
<div class="row g-3">
    <div class="col-lg-5">
        <div class="card p-4 rounded-4 bg-white">
            <h4>Total Earnings</h4>
            <p class="display-6 fw-bold">{{ number_format($total, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card p-4 rounded-4 bg-white">
            <h4>Monthly Breakdown</h4>
            @foreach($monthly as $m)
                <div class="d-flex justify-content-between mb-2">
                    <div class="text-muted">{{ $m->month }}</div>
                    <div class="fw-semibold">{{ number_format($m->total, 0, ',', '.') }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-12 mt-3">
        <div class="card p-4 rounded-4 bg-white">
            <h5>Payment History</h5>
            @foreach($payments as $p)
                <div class="d-flex justify-content-between mb-2">
                    <div class="text-muted small">{{ $p->created_at->format('d M Y') }}</div>
                    <div class="fw-semibold">{{ $p->status }}</div>
                </div>
            @endforeach
            <div class="mt-3">{{ $payments->links() }}</div>
        </div>
    </div>
</div>
@endsection
