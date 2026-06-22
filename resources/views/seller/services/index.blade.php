@extends('layouts.seller-dashboard')

@section('content')
<div class="dashboard-page">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>My Services</h3>
        <a href="{{ route('seller.services.create') }}" class="btn btn-primary">Create Service</a>
    </div>

    <div class="row g-3">
        @foreach($services as $service)
            <div class="col-12 col-md-6">
                <div class="card p-3 rounded-4 bg-white">
                    @if($service->primary_image)
                        <img src="{{ $service->primary_image }}" class="card-img-top rounded-4 mb-3" alt="Service image" style="height: 180px; object-fit: cover; width: 100%;">
                    @endif
                    <h5>{{ $service->title }}</h5>
                    <p class="text-muted small">{{ $service->category?->name }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-semibold">{{ number_format($service->price, 0, ',', '.') }}</div>
                        <div>
                            <a href="{{ route('seller.services.edit', $service) }}" class="text-primary">Edit</a>
                            <form action="{{ route('seller.services.destroy', $service) }}" method="POST" class="d-inline ms-2">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link text-danger p-0" onclick="return confirm('Delete service?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $services->links() }}</div>
</div>
@endsection
