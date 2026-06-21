@extends('layouts.dashboard')

@section('content')
<div class="dashboard-page">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card rounded-4 shadow-sm p-4 bg-white">
                <div class="d-flex align-items-center gap-4 mb-4">
                    <div class="profile-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:72px;height:72px;overflow:hidden;">
                        @if(! empty($profile['photo']))
                            <img src="{{ asset('storage/' . $profile['photo']) }}" alt="Profile" class="rounded-circle" style="width:72px;height:72px;object-fit:cover;">
                        @else
                            <span class="fs-3">A</span>
                        @endif
                    </div>
                    <div>
                        <h2 class="h4 fw-bold mb-1">{{ $profile['name'] }}</h2>
                        <p class="text-muted mb-1">{{ $profile['email'] }}</p>
                        <p class="text-muted mb-0">{{ $profile['bio'] }}</p>
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    @foreach($profile['stats'] as $label => $value)
                        <div class="col-4">
                            <div class="p-3 rounded-4 bg-primary bg-opacity-10 text-center">
                                <p class="mb-1 text-muted small">{{ $label }}</p>
                                <p class="mb-0 fw-semibold">{{ $value }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div>
                    <h3 class="h6 fw-semibold mb-3">Skills</h3>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($profile['skills'] as $skill)
                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card rounded-4 shadow-sm p-4 bg-white">
                <h3 class="h6 fw-semibold mb-3">About</h3>
                <p class="text-muted">Sebagai klien yang aktif, Anda dapat mengelola pesanan, menghubungi freelancer, dan melihat notifikasi dengan cepat dari client workspace ini.</p>
                <div class="mt-4">
                    <a href="{{ route('dashboard.profile.edit') }}" class="btn btn-primary rounded-pill px-4">Edit profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
