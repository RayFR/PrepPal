<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    // Show the contact page
    public function index()
    {
        return view('frontend.contact');
    }

    // Handle form submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $message = trim((string) $validated['message']);

        if (!empty($validated['subject'])) {
            $message = '[Topic: ' . $validated['subject'] . ']' . "\n\n" . $message;
        }

        Contact::create([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'message' => $message,
        ]);

        return redirect()
            ->route('contact.index')
            ->with('success', 'Thanks — your message has been sent. Our team will get back to you within 24 hours.');
    }
}