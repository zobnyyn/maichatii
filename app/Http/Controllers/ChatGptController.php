<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatGptController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message');
        if (!$message) {
            return response()->json(['error' => 'Нет сообщения'], 400);
        }
        $apiKey = env('OPENROUTER_API_KEY');
        $referer = env('OPENROUTER_REFERER', 'https://localhost');
        $title = env('OPENROUTER_TITLE', 'Cyberpunk UI');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'HTTP-Referer' => $referer,
            'X-Title' => $title,
            'Content-Type' => 'application/json',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'openai/gpt-4o',
            'messages' => [
                ['role' => 'user', 'content' => $message]
            ],
            'max_tokens' => 128,
        ]);
        if ($response->failed()) {
            $errorText = $response->body();
            return response()->json(['error' => 'Ошибка OpenRouter', 'details' => $errorText], 500);
        }
        $data = $response->json();
        $answer = $data['choices'][0]['message']['content'] ?? 'Нет ответа';
        return response()->json(['answer' => $answer]);
    }
}
