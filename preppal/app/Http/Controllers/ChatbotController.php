<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function send(Request $request)
    {
        $message = $request->input('message');
        $response = Http::withToken(env('OPEN_AI_KEY'))
        ->post('https://api.openai.com/v1/responses', [
        'model' => 'gpt-4.1-mini',
        'input' => "You are Preppal's assistant. Help with meal prep and nutrition. User: " . $message
        ]);

        return response()->json([
            'reply' => $response->json()['output'][0]['content'][0]['text'] ?? 'No response'
        ]);
    }
}