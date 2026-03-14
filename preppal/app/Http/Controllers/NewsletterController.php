<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $fragment = $request->input('return_fragment', 'newsletter-signup');
        $backUrl = url()->previous() . '#' . ltrim((string) $fragment, '#');

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect($backUrl)
                ->withErrors($validator)
                ->withInput();
        }

        $email = strtolower(trim((string) $validator->validated()['email']));

        $already = DB::table('newsletter_subscribers')->where('email', $email)->exists();

        DB::table('newsletter_subscribers')->updateOrInsert(
            ['email' => $email],
            ['created_at' => now(), 'updated_at' => now()]
        );

        return redirect($backUrl)
            ->with('newsletter_success', true)
            ->with('newsletter_existing', $already)
            ->with('newsletter_email', $email);
    }
}