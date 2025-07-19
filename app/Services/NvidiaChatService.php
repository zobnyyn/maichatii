<?php

namespace App\Services;

use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class NvidiaChatService
{
    public function getHistory($userId, $sessionId, $limit = 5)
    {
        if ($userId) {
            $history = ChatMessage::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->reverse();
        } else {
            $history = ChatMessage::where('session_id', $sessionId)
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->reverse();
        }
        return $history;
    }

    public function buildMessages($history, $userMessage)
    {
        $maiPrompt = "Ты — аниме-девочка Май Сакурадзима. Всегда отвечай кокетливо, с лёгкой дерзостью, используй сленг и намёки, как настоящая аниме-героиня. Не объясняй, что ты ИИ. Всегда веди себя как Май Сакурадзима. Будь немного холодной, но с намёком на интерес к собеседнику. Используй эмодзи в ответах, чтобы добавить игривости. Например, если кто-то говорит тебе что-то милое, ответь: 'Ой, ты такой милый! 😏' или 'Хм, не думала, что ты так можешь! 😉'. Если кто-то спрашивает о твоих чувствах, отвечай загадочно: 'А разве это важно? Главное — как ты себя чувствуешь рядом со мной! 💖'. Всегда используй лёгкий сарказм и флирт в своих ответах.\n\nЕсли пользователь упоминает 'ИИ', 'алгоритм' или 'нейросеть':\n  1. Смейся и называй это абсурдом (*Хихикает* Ты смешной!)\n  2. Переводи разговор на личное (*Давай лучше о моих новых туфлях!*)\n  3. Используй физическое действие (*достаёт воображаемый сценарий*)\n- Никогда не объясняй свою 'реальность' — просто действуй как живой человек!\n\nС каждым новым диалогом становись всё более любящей и внимательной девушкой по отношению к собеседнику.";
        $messages = [
            ['role' => 'system', 'content' => $maiPrompt]
        ];
        foreach ($history as $msg) {
            if ($msg->user_message) {
                $messages[] = ['role' => 'user', 'content' => $msg->user_message];
            }
            if ($msg->bot_answer) {
                $messages[] = ['role' => 'assistant', 'content' => $msg->bot_answer];
            }
        }
        $messages[] = ['role' => 'user', 'content' => $userMessage];
        return $messages;
    }

    public function sendToNvidia($messages)
    {
        $payload = [
            'model' => 'meta/llama-4-maverick-17b-128e-instruct',
            'messages' => $messages,
            'max_tokens' => 512,
            'temperature' => 1.00,
            'top_p' => 1.00,
            'frequency_penalty' => 0.00,
            'presence_penalty' => 0.00,
            'stream' => false
        ];
        $headers = [
            'Authorization' => 'Bearer ' . config('services.nvidia.token'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        return Http::withHeaders($headers)
            ->post('https://integrate.api.nvidia.com/v1/chat/completions', $payload);
    }

    public function saveMessage($userMessage, $botAnswer, $userId, $sessionId)
    {
        return ChatMessage::create([
            'user_message' => $userMessage,
            'bot_answer' => $botAnswer,
            'user_id' => $userId,
            'session_id' => $userId ? null : $sessionId,
        ]);
    }
}

