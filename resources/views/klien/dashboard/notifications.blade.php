@extends('layouts.dashboard')

@section('content')
<div class="dashboard-page">
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Notifications</h2>
        <p class="text-muted mb-0">Notifikasi terbaru dari aktivitas pesanan dan pesan Anda.</p>
    </div>
    <div class="list-group notification-list rounded-4 shadow-sm bg-white">
        @foreach($notifications as $notification)
            <div class="list-group-item d-flex justify-content-between align-items-center border-0 rounded-4 mb-2 p-4 {{ $notification['unread'] ? 'notification-unread' : '' }}">
                <div>
                    <p class="mb-1 fw-semibold">{{ $notification['title'] }}</p>
                    <small class="text-muted">{{ $notification['time'] }}</small>
                </div>
                @if($notification['unread'])
                    <span class="badge bg-primary">New</span>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
