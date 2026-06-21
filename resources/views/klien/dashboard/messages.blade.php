@extends('layouts.dashboard')

@section('content')
<div class="dashboard-page">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card rounded-4 shadow-sm bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="h5 mb-1">Messages</h2>
                            <p class="text-muted mb-0">Chat history with your freelancers.</p>
                        </div>
                        <button class="btn btn-outline-secondary btn-sm rounded-pill" type="button">New</button>
                    </div>
                    <div class="mb-3">
                        <input type="search" class="form-control form-control-sm rounded-pill" placeholder="Search chat" aria-label="Search chat" />
                    </div>
                    <div class="list-group chat-list">
                        @foreach($chats as $chat)
                            <a href="{{ route('dashboard.message.detail', ['id' => $chat['id']]) }}" class="list-group-item list-group-item-action rounded-4 mb-2 {{ $chat['unread'] ? 'chat-unread' : '' }}">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong>{{ $chat['name'] }}</strong>
                                    <small class="text-muted">{{ $chat['time'] }}</small>
                                </div>
                                <p class="mb-0 text-muted small">{{ $chat['preview'] }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card rounded-4 shadow-sm bg-white h-100 d-flex flex-column">
                <div class="card-body p-4 flex-grow-1 d-flex flex-column justify-content-center align-items-center text-center">
                    <div class="mb-3 text-primary fs-1"><i class="bi bi-chat-dots"></i></div>
                    <h3 class="h5 fw-bold">Pilih percakapan</h3>
                    <p class="text-muted">Pilih chat dari panel kiri untuk melihat pesan secara langsung dan membalas freelancer.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
