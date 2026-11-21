<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactMessage::latest();

        if ($request->has('status') && in_array($request->status, ['unread', 'read', 'archived'])) {
            $query->where('status', $request->status);
        }

        $messages = $query->paginate(20);
        $unreadCount = ContactMessage::where('status', 'unread')->count();

        return view('admin.contacts.index', compact('messages', 'unreadCount'));
    }

    public function show(ContactMessage $contact): View
    {
        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.contacts.show', ['message' => $contact]);
    }

    public function archive(ContactMessage $contact): RedirectResponse
    {
        $newStatus = $contact->status === 'archived' ? 'read' : 'archived';
        $contact->update(['status' => $newStatus]);

        ActivityLog::log('contacts.status_change', ['id' => $contact->id, 'status' => $newStatus]);

        return redirect()->back()->with('success', "Message marked as {$newStatus}.");
    }

    public function destroy(ContactMessage $contact): RedirectResponse
    {
        $contact->delete();
        ActivityLog::log('contacts.deleted', ['id' => $contact->id]);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message deleted successfully.');
    }
}
