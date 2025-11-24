<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class TelegramHelper
{
    public static function sendMessage($chatId, $message)
    {
        $token = config('services.telegram.bot_token');

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        return Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }
}
