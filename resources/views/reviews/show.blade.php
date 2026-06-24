@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card p-4 rounded-4">
        <div class="d-flex align-items-center mb-3">
            <img src="{{ $review->reviewer->profile?->photo ?? asset('assets/default-user.png') }}" alt="avatar" class="rounded-circle me-3" style="width:64px;height:64px;object-fit:cover;" />
            <div>
                <strong>{{ $review->reviewer?->name }}</strong>
                <div class="text-muted small">Reviewed on {{ $review->created_at->format('F j, Y') }}</div>
            </div>
        </div>

        <div class="mb-3">
            <h5>{{ $review->service?->title }}</h5>
            @if($review->service?->primary_image)
                <img src="{{ $review->service->primary_image }}" alt="thumb" class="img-thumbnail" style="width:120px;height:80px;object-fit:cover;" />
            @endif
            <div class="text-muted small">Seller: {{ $review->seller?->name }}</div>
            <div class="text-muted small">Order: {{ $review->order?->order_code ?? $review->order?->id }}</div>
        </div>

        <div class="mb-3">
            <div class="mb-2">Rating:
                @for($i=1;$i<=5;$i++)
                    @if($i <= $review->rating)
                        <i class="bi bi-star-fill text-warning"></i>
                    @else
                        <i class="bi bi-star text-muted"></i>
                    @endif
                @endfor
            </div>
            <p class="mb-1">{{ $review->comment }}</p>
            @if($review->feedback)
                <div class="mt-2"><strong>Feedback:</strong> {{ $review->feedback }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
