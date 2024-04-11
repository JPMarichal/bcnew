<?php
namespace App\Services\SocialMedia;

use App\Services\SocialMedia\Contracts\SocialMediaInterface;
use Telegram\Bot\Api; // SDK de Telegram Bot

class TelegramService implements SocialMediaInterface
{
    protected $telegram;

    public function __construct()
    {
        $this->telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    public function postMessage($message)
    {
        $chatId = env('TELEGRAM_CHAT_ID');
        $this->telegram->sendMessage([
            'chat_id' => $chatId, 
            'text' => $message
        ]);
    }

    public function postImage($imagePath)
    {
        $chatId = env('TELEGRAM_CHAT_ID');
        $this->telegram->sendPhoto([
            'chat_id' => $chatId, 
            'photo' => $imagePath
        ]);
    }

    public function postMessageWithImage($message, $imagePath)
    {
        $chatId = env('TELEGRAM_CHAT_ID');
        $this->telegram->sendPhoto([
            'chat_id' => $chatId, 
            'photo' => $imagePath,
            'caption' => $message
        ]);
    }
}
