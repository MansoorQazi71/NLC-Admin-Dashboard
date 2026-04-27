@extends('layouts.admin')

@section('title', 'Chat')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="top-title mb-1">Chat</h1>
            <p class="top-subtitle mb-0">Communiquez avec votre equipe et vos clients</p>
        </div>
        <a href="{{ route('admin.chat.index', ['new' => 1]) }}" class="btn btn-dark rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i>Nouvelle conversation
        </a>
    </div>

    @if($showCreateForm)
        <div class="page-card p-3 mb-4">
            <form method="POST" action="{{ route('admin.chat.store') }}" class="row g-2 align-items-end">
                @csrf
                <div class="col-md-5">
                    <label for="title" class="form-label mb-1">Conversation title</label>
                    <input id="title" name="title" class="form-control @error('title') is-invalid @enderror" maxlength="255" required placeholder="e.g. Customer follow-up" value="{{ old('title') }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="receiver_id" class="form-label mb-1">Receiver</label>
                    <select id="receiver_id" name="receiver_id" class="form-select @error('receiver_id') is-invalid @enderror" required>
                        <option value="">Select receiver</option>
                        @foreach($receivers as $receiver)
                            <option value="{{ $receiver->id }}" @selected((int) old('receiver_id') === $receiver->id)>{{ $receiver->name }} ({{ $receiver->email }})</option>
                        @endforeach
                    </select>
                    @error('receiver_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-primary">Create conversation</button>
                </div>
            </form>
        </div>
    @endif
    <div class="page-card overflow-hidden" style="min-height: 620px;">
        <div class="row g-0 h-100">
        <div class="col-md-4 border-end p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Conversations</h5>
            </div>
            <div class="list-group list-group-flush">
                @forelse($conversations as $conv)
                    <a href="{{ route('admin.chat.index', ['conversation' => $conv->id]) }}" class="list-group-item list-group-item-action border-0 px-2 py-3 {{ optional($selectedConversation)->id === $conv->id ? 'active rounded-3' : '' }}">
                        <div class="fw-semibold">{{ $conv->title }}</div>
                        <div class="small {{ optional($selectedConversation)->id === $conv->id ? 'text-white-50' : 'text-muted' }}">
                            {{ $conv->sender?->name }} -> {{ $conv->receiver?->name }}
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-muted">Aucune conversation.</p>
                @endforelse
            </div>
            @if($conversations->hasPages())
                <div class="pt-3">
                    {{ $conversations->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
        @if($selectedConversation)
            <div class="col-md-8 d-flex flex-column">
                <div class="p-4 border-bottom">
                    <h4 class="mb-1">{{ $selectedConversation->title }}</h4>
                    <p class="text-muted mb-0">
                        Sender: {{ $selectedConversation->sender?->name ?? '-' }} |
                        Receiver: {{ $selectedConversation->receiver?->name ?? '-' }}
                    </p>
                </div>
                <div class="flex-grow-1 p-3 overflow-auto" style="max-height: 430px;">
                    @forelse($messages ?? [] as $message)
                        <div class="mb-3 d-flex {{ $message->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="p-3 rounded-3 {{ $message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 75%;">
                                <div class="small fw-semibold mb-1">{{ $message->sender?->name }}</div>
                                <div>{{ $message->body }}</div>
                                <div class="small mt-1 {{ $message->sender_id === auth()->id() ? 'text-white-50' : 'text-muted' }}">{{ $message->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-chat-dots fs-1 d-block mb-2"></i>
                            No messages yet in this conversation.
                        </div>
                    @endforelse
                </div>
                @if($messages && $messages->hasPages())
                    <div class="px-3 pb-2">
                        {{ $messages->links('pagination::bootstrap-5') }}
                    </div>
                @endif
                <div class="border-top p-3">
                    <form method="POST" action="{{ route('admin.chat.messages.store', $selectedConversation) }}" class="d-flex gap-2">
                        @csrf
                        <input type="text" name="body" class="form-control @error('body') is-invalid @enderror" placeholder="Type a message..." required maxlength="3000">
                        <button class="btn btn-primary"><i class="bi bi-send"></i></button>
                    </form>
                    @error('body')
                        <div class="small text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        @else
            <div class="col-md-8 d-flex align-items-center justify-content-center text-muted">
                <div class="text-center">
                    <i class="bi bi-chat fs-1 d-block mb-2"></i>
                    <h4>Selectionnez une conversation</h4>
                    <p>Choisissez une conversation dans la liste ou creez-en une nouvelle</p>
                </div>
            </div>
        @endif
        </div>
    </div>

@endsection
