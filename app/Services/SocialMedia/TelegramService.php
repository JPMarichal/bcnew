<?php
namespace App\Services\SocialMedia;

use App\Services\SocialMedia\Contracts\SocialMediaInterface;
use Telegram\Bot\Api; // SDK de Telegram Bot
use Illuminate\Support\Facades\Config;

class TelegramService implements SocialMediaInterface
{
    protected $telegram;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    public function postMessage($message)
    {
        try {
            $this->telegram->sendMessage([
                'chat_id' => Config::get('services.telegram.chat_id'), 
                'text' => $message
            ]);
        } catch (\Exception $e) {
            // Manejo de la excepción
            throw new \Exception("Error al enviar mensaje a Telegram: " . $e->getMessage());
        }
    }

    public function postImage($imagePath)
    {
        try {
            $this->telegram->sendPhoto([
                'chat_id' => Config::get('services.telegram.chat_id'), 
                'photo' => $imagePath
            ]);
        } catch (\Exception $e) {
            // Manejo de la excepción
            throw new \Exception("Error al enviar imagen a Telegram: " . $e->getMessage());
        }
    }

    public function postMessageWithImage($message, $imagePath)
    {
        try {
            $this->telegram->sendPhoto([
                'chat_id' => Config::get('services.telegram.chat_id'), 
                'photo' => $imagePath,
                'caption' => $message
            ]);
        } catch (\Exception $e) {
            // Manejo de la excepción
            throw new \Exception("Error al enviar mensaje con imagen a Telegram: " . $e->getMessage());
        }
    }
}
