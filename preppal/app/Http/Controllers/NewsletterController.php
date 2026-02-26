<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $email = strtolower(trim($data['email']));

        $already = DB::table('newsletter_subscribers')->where('email', $email)->exists();

        DB::table('newsletter_subscribers')->updateOrInsert(
            ['email' => $email],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // ✅ This makes the modal open in "success screen" mode after submit
        return back()
            ->with('newsletter_success', true)
            ->with('newsletter_existing', $already);
    }
}
