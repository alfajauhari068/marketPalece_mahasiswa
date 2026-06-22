@extends('layouts.seller-dashboard')

@section('content')
<div class="dashboard-page">
    <section class="dashboard-hero mb-4">
        <div class="hero-copy p-4 rounded-4 shadow-sm bg-white">
            <h2 class="fw-bold mb-1">Settings</h2>
            <p class="text-muted mb-0">Atur preferensi akun dan notifikasi untuk pengalaman jualan yang lebih lancar.</p>
        </div>
    </section>

    <div class="card rounded-4 shadow-sm bg-white p-4">
        <div class="row g-4">
            <div class="col-12 col-md-6">
                <h5 class="mb-3">Account</h5>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                    <label class="form-check-label" for="emailNotifications">Email notifications</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="smsAlerts">
                    <label class="form-check-label" for="smsAlerts">SMS order alerts</label>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <h5 class="mb-3">Security</h5>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="twoFactorAuth" checked>
                    <label class="form-check-label" for="twoFactorAuth">Two-factor authentication</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="sessionManagement">
                    <label class="form-check-label" for="sessionManagement">Remember devices</label>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
