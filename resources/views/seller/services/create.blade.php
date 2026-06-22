@extends('layouts.seller-dashboard')

@section('content')
<div class="card p-4 rounded-4 bg-white">
    <h3>Create Service</h3>
    <form action="{{ route('seller.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            @error('title')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            @error('description')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="row g-3">
            <div class="col-md-4 mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}">
                @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Service Images</label>
                <input type="file" name="images[]" class="form-control" accept="image/png,image/jpeg,image/webp" multiple>
                <div class="form-text">Unggah maksimal 5 gambar. Tipe: JPG, JPEG, PNG, WEBP. Maks 2MB per gambar.</div>
                @error('images')<div class="text-danger small">{{ $message }}</div>@enderror
                @error('images.*')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="paused" {{ old('status') == 'paused' ? 'selected' : '' }}>Paused</option>
                    <option value="live" {{ old('status') == 'live' ? 'selected' : '' }}>Live</option>
                </select>
                @error('status')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
