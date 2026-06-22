@extends('layouts.seller-dashboard')

@section('content')
<div class="card p-4 rounded-4 bg-white">
    <h3>Edit Service</h3>
    <form action="{{ route('seller.services.update', $service) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $service->title) }}">
            @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $service->description) }}</textarea>
            @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="row g-3">
            <div class="col-md-4 mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $service->price) }}">
                @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Service Images</label>
                <input type="file" name="images[]" class="form-control" accept="image/png,image/jpeg,image/webp" multiple>
                <div class="form-text">Unggah gambar baru untuk ditambahkan. Maks 5 gambar total.</div>
                @error('images')<div class="text-danger small">{{ $message }}</div>@enderror
                @error('images.*')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $service->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="draft" {{ old('status', $service->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="paused" {{ old('status', $service->status) == 'paused' ? 'selected' : '' }}>Paused</option>
                    <option value="live" {{ old('status', $service->status) == 'live' ? 'selected' : '' }}>Live</option>
                </select>
                @error('status')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
        </div>

        @if($service->images->count())
            <div class="mb-4">
                <label class="form-label">Current images</label>
                <div class="row g-2">
                    @foreach($service->images as $image)
                        <div class="col-6 col-md-4">
                            <div class="position-relative rounded-4 overflow-hidden border">
                                <img src="{{ $image->url }}" alt="Service image" class="img-fluid">
                                <label class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-50 text-white small m-0 p-2 d-flex justify-content-between align-items-center">
                                    <span>#{{ $loop->iteration }}</span>
                                    <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="form-check-input bg-white border-0" style="width: 1.2rem; height: 1.2rem;">
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-text">Centang gambar yang ingin dihapus saat update.</div>
                @error('remove_images')<div class="text-danger small">{{ $message }}</div>@enderror
                @error('remove_images.*')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
        @endif

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
