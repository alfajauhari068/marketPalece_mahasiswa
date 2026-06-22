@extends('layouts.seller-dashboard')

@section('content')
<div class="card p-4 rounded-4 bg-white">
    <h3>Reviews</h3>
    <div class="mt-3">
        @foreach($reviews as $review)
            <div class="mb-3">
                <strong>{{ $review->reviewer?->name }}</strong>
                <div class="text-muted small">Order #{{ $review->order?->id }}</div>
                <p class="mb-0 text-muted">{{ $review->comment }}</p>
            </div>
        @endforeach
    </div>
    <div class="mt-3">{{ $reviews->links() }}</div>
</div>
@endsection
