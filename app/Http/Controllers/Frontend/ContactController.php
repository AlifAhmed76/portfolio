<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request): RedirectResponse
    {
        // 1. Honeypot check: bot trap
        if ($request->filled('hp_website')) {
            // Silently ignore bot submission
            return redirect()->back()->with('contact_success', 'Thank you! Your message has been transmitted successfully.');
        }

        // 2. Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string|max:3000',
        ]);

        // 3. Store message
        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] ?? 'Website Inquiry',
            'message' => $validated['message'],
            'ip_address' => hash('sha256', $request->ip() ?? 'unknown'),
            'status' => 'unread',
        ]);

        return redirect()->back()->with('contact_success', 'Thank you! Your message has been received. I will review and reply promptly.');
    }
}
