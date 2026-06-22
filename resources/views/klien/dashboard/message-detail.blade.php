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
                            <p class="text-muted mb-0">Select a conversation to continue.</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="search" class="form-control form-control-sm rounded-pill" placeholder="Search chat" aria-label="Search chat" />
                    </div>
                    <div class="list-group chat-list">
                        @forelse($chats as $item)
                            <a href="{{ route('dashboard.message.detail', ['id' => $item['id']]) }}" class="list-group-item list-group-item-action rounded-4 mb-2 {{ $item['id'] === $chat['id'] ? 'active' : '' }}">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong>{{ $item['name'] }}</strong>
                                    <small class="text-muted">{{ $item['time'] }}</small>
                                </div>
                                <p class="mb-0 text-muted small">{{ $item['preview'] }}</p>
                            </a>
                        @empty
                            <div class="list-group-item border-0 text-muted">No conversations</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 d-flex flex-column">
            <div class="card rounded-4 shadow-sm bg-white flex-grow-1 d-flex flex-column">
                <div class="card-body p-4 flex-grow-1 d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h3 class="h6 mb-1">{{ $chat['name'] }}</h3>
                            <small class="text-muted">{{ $chat['status'] }}</small>
                        </div>
                        <button class="btn btn-outline-secondary btn-sm rounded-pill">Mark read</button>
                    </div>
                    <div class="chat-window flex-grow-1 overflow-auto mb-4">
                        @foreach($chat['messages'] as $message)
                            <div class="message-bubble {{ $message['author'] === 'client' ? 'sent' : 'received' }} mb-3">
                                <p class="mb-1">{{ $message['text'] }}</p>
                                <small class="text-muted">{{ $message['time'] }}</small>
                            </div>
                        @endforeach
                    </div>
                    <form class="d-flex gap-2 align-items-center" action="#" method="post">
                        <input type="text" class="form-control rounded-pill" placeholder="Type a message" aria-label="Type a message">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
