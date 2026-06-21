@extends('layouts.dashboard')

@section('content')
<div class="dashboard-page">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Edit Profile</h2>
        <p class="text-muted mb-0">Perbarui informasi profil, bio, dan keterampilan Anda.</p>
    </div>
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card rounded-4 shadow-sm bg-white p-4">
        <form action="{{ route('dashboard.profile.update') }}" method="post" class="row g-4" enctype="multipart/form-data">
            @csrf
            <div class="col-12 col-md-4">
                <label class="form-label fw-semibold">Profile Image</label>
                <div class="profile-image-upload rounded-4 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mb-3">
                    @if(! empty($profile['photo']))
                        <img src="{{ asset('storage/' . $profile['photo']) }}" alt="Profile" class="rounded-circle" style="width:96px;height:96px;object-fit:cover;">
                    @else
                        <span class="text-primary fs-2">A</span>
                    @endif
                </div>
                <input class="form-control" type="file" name="photo" aria-label="Upload profile image">
            </div>
            <div class="col-12 col-md-8">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $profile['name'] }}">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $profile['email'] }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Bio</label>
                        <textarea name="bio" class="form-control" rows="4">{{ $profile['bio'] }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Skills</label>
                        <input type="text" name="skills" class="form-control" value="{{ implode(', ', $profile['skills']) }}" placeholder="Add skills separated by commas">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Rating</label>
                        <input type="number" step="0.1" min="0" max="5" name="rating_avg" class="form-control" value="{{ $profile['rating_avg'] }}">
                    </div>
                </div>
            </div>
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary rounded-pill px-4">Save changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
