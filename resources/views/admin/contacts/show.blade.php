@extends('layouts.admin')

@section('title', 'Message from: ' . $message->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.contacts.index') }}" class="text-secondary text-decoration-none small d-flex align-items-center gap-1 mb-2">
        <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i> Back to Inbox
    </a>
    <h1 class="h3 fw-bold mb-1">Inquiry Details</h1>
    <p class="text-secondary mb-0">Received on {{ $message->created_at->format('F d, Y \a\t H:i:s') }}</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4 mb-4" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border) !important; color: var(--admin-text);">
            <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-4" style="border-color: var(--admin-border) !important;">
                <div>
                    <h5 class="fw-bold mb-1 text-body">{{ $message->subject }}</h5>
                    <div class="text-secondary small">
                        From: <strong class="text-body fw-bold">{{ $message->name }}</strong> (<a href="mailto:{{ $message->email }}" class="text-primary">{{ $message->email }}</a>)
                    </div>
                </div>
                <span class="badge {{ $message->status === 'unread' ? 'bg-warning-subtle text-warning' : ($message->status === 'read' ? 'bg-secondary-subtle text-secondary' : 'bg-body-secondary border border-secondary') }} px-2 py-1">
                    {{ ucfirst($message->status) }}
                </span>
            </div>

            <div class="p-4 rounded-3 mb-4 bg-body-tertiary" style="border: 1px solid var(--admin-border); min-height: 200px;">
                <div class="text-body leading-relaxed fs-6" style="white-space: pre-wrap; word-break: break-word; font-family: inherit;">{{ $message->message }}</div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="mailto:{{ $message->email }}?subject={{ urlencode('Re: ' . $message->subject) }}" class="btn btn-primary d-flex align-items-center gap-2">
                    <i data-lucide="mail"></i>
                    <span>Reply via Email</span>
                </a>

                <div class="d-flex gap-2">
                    <form action="{{ route('admin.contacts.archive', $message) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-secondary">
                            {{ $message->status === 'archived' ? 'Unarchive' : 'Archive' }}
                        </button>
                    </form>

                    <form action="{{ route('admin.contacts.destroy', $message) }}" method="POST" onsubmit="return confirm('Permanently delete this message?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
