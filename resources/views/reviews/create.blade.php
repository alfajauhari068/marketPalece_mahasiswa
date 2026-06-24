@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card p-4 rounded-4">
        <h4 class="mb-3">Review Service</h4>

        <div class="mb-3">
            <div class="d-flex align-items-center">
                <img src="{{ optional($order->service->primary_image) ?? asset('assets/default-service.png') }}" alt="thumb" class="me-3 rounded" style="width:80px;height:80px;object-fit:cover;" />
                <div>
                    <h5 class="mb-1">{{ $order->service->title }}</h5>
                    <div class="text-muted small">Seller: {{ $order->seller?->name }}</div>
                    <div class="text-muted small">Order: #{{ $order->order_code ?? $order->id }}</div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('review.store', $order->id) }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Rating</label>
                <select name="rating" class="form-select @error('rating') is-invalid @enderror">
                    <option value="">Select rating</option>
                    @for($i=5;$i>=1;$i--)
                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} star{{ $i>1? 's':'' }}</option>
                    @endfor
                </select>
                @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Comment</label>
                <textarea name="comment" rows="4" class="form-control @error('comment') is-invalid @enderror">{{ old('comment') }}</textarea>
                @error('comment')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Feedback (optional)</label>
                <textarea name="feedback" rows="3" class="form-control @error('feedback') is-invalid @enderror">{{ old('feedback') }}</textarea>
                @error('feedback')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </div>
        </form>
    </div>
</div>
@endsection
