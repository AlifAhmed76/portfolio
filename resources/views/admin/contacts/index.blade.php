@extends('layouts.admin')

@section('title', 'Contact Inbox')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Contact Inbox</h1>
        <p class="text-secondary mb-0">Inquiries received via the public portfolio contact form (honeypot & rate-limit protected).</p>
    </div>
    @if ($unreadCount > 0)
        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
            {{ $unreadCount }} Unread {{ Str::plural('Inquiry', $unreadCount) }}
        </span>
    @endif
</div>

<div class="card border-0 shadow-sm" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border) !important; color: var(--admin-text);">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="color: inherit;">
            <thead class="table-light border-bottom">
                <tr>
                    <th scope="col" class="ps-4">Sender</th>
                    <th scope="col">Subject / Preview</th>
                    <th scope="col">Status</th>
                    <th scope="col">Received At</th>
                    <th scope="col" class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $msg)
                    <tr class="{{ $msg->isUnread() ? 'table-active fw-semibold' : '' }}">
                        <td class="ps-4">
                            <div>{{ $msg->name }}</div>
                            <small class="text-secondary">{{ $msg->email }}</small>
                        </td>
                        <td>
                            <div>{{ $msg->subject }}</div>
                            <small class="text-secondary">{{ Str::limit($msg->message, 80) }}</small>
                        </td>
                        <td>
                            @if ($msg->status === 'unread')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Unread</span>
                            @elseif ($msg->status === 'read')
                                <span class="badge bg-secondary-subtle text-secondary">Read</span>
                            @else
                                <span class="badge bg-dark border border-secondary text-secondary">Archived</span>
                            @endif
                        </td>
                        <td class="text-secondary small">
                            {{ $msg->created_at->diffForHumans() }}
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                <a href="{{ route('admin.contacts.show', $msg) }}" class="btn btn-sm btn-outline-primary" title="View Message">
                                    <i data-lucide="eye" style="width: 14px; height: 14px;"></i>
                                </a>
                                <form action="{{ route('admin.contacts.archive', $msg) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="{{ $msg->status === 'archived' ? 'Unarchive' : 'Archive' }}">
                                        <i data-lucide="archive" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.contacts.destroy', $msg) }}" method="POST" onsubmit="return confirm('Permanently delete this message?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-secondary">
                            <i data-lucide="inbox" class="mb-2" style="width: 32px; height: 32px;"></i>
                            <p class="mb-0">Inbox is empty. No messages received yet.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($messages->hasPages())
        <div class="p-3 border-top" style="border-color: var(--admin-border) !important;">
            {{ $messages->links() }}
        </div>
    @endif
</div>
@endsection
