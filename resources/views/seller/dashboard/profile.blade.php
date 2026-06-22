@extends('layouts.seller-dashboard')

@section('content')
<div class="dashboard-page">
    <section class="dashboard-hero mb-4">
        <div class="hero-copy p-4 rounded-4 shadow-sm bg-white">
            <h2 class="fw-bold mb-1">Seller Profile</h2>
            <p class="text-muted mb-0">Lengkapi informasi toko dan tampilkan personal brand Anda kepada calon buyer.</p>
        </div>
    </section>

    <div class="card rounded-4 shadow-sm bg-white p-4">
        <div class="row g-4">
            <div class="col-lg-4 text-center">
                <div class="seller-profile-avatar mx-auto mb-3 rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center" style="width: 130px; height: 130px; overflow: hidden;">
                    @if($user->profile?->photo)
                        <img src="{{ asset('storage/' . $user->profile->photo) }}" alt="Profile photo" class="img-fluid h-100 w-100" style="object-fit: cover;">
                    @else
                        <i class="bi bi-person fs-1 text-primary"></i>
                    @endif
                </div>
                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                <p class="badge bg-primary bg-opacity-10 text-primary py-2 px-3 rounded-pill">Seller</p>
            </div>
            <div class="col-lg-8">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="border rounded-4 p-3">
                            <h6 class="text-muted mb-2">Joined</h6>
                            <p class="mb-0">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="border rounded-4 p-3">
                            <h6 class="text-muted mb-2">Services</h6>
                            <p class="mb-0">{{ $serviceCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h5 class="mb-3">About your shop</h5>
                    <p class="text-muted">{{ $user->profile?->bio ?? 'Belum ada deskripsi toko. Tambahkan detail yang menarik untuk meningkatkan kepercayaan buyer.' }}</p>
                </div>
                <div class="mt-4">
                    <h5 class="mb-3">Foto Profil Seller</h5>
                    <form action="{{ route('seller.profile.photo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="file" name="photo" class="form-control" accept="image/png,image/jpeg">
                            @error('photo')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <button class="btn btn-outline-primary btn-sm">Unggah Foto Profil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
