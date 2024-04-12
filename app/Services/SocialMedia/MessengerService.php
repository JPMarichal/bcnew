<?php
namespace App\Services\SocialMedia;

use App\Services\SocialMedia\Contracts\SocialMediaInterface;
use GuzzleHttp\Client;

class MessengerService implements SocialMediaInterface
{
    protected $client;
    protected $pageAccessToken;
    protected $recipientId; // Este ID debería ser dinámico según tu aplicación

    public function __construct()
    {
        $this->client = new Client();
        $this->pageAccessToken = env('MESSENGER_PAGE_ACCESS_TOKEN');
        $this->recipientId = 'RECIPIENT_ID'; // Define cómo obtendrás este ID en tu aplicación
    }

    public function postMessage($message)
    {
        $url = 'https://graph.facebook.com/v13.0/me/messages';
        $params = [
            'query' => ['access_token' => $this->pageAccessToken],
            'json' => [
                'recipient' => ['id' => $this->recipientId],
                'message' => ['text' => $message]
            ],
        ];

        return $this->client->post($url, $params);
    }

    public function postImage($imagePath)
    {
        // Messenger requiere el uso de adjuntos para enviar imágenes
        $url = 'https://graph.facebook.com/v13.0/me/messages';
        $params = [
            'query' => ['access_token' => $this->pageAccessToken],
            'json' => [
                'recipient' => ['id' => $this->recipientId],
                'message' => [
                    'attachment' => [
                        'type' => 'image',
                        'payload' => [
                            'url' => $imagePath, 'is_reusable' => true
                        ],
                    ],
                ],
            ],
        ];

        return $this->client->post($url, $params);
    }

    public function postMessageWithImage($message, $imagePath)
    {
        // Esta implementación no es directamente soportada por Messenger API de una manera simple.
        // Podrías enviar el mensaje primero y luego la imagen como dos acciones separadas.
        $this->postMessage($message);
        return $this->postImage($imagePath);
    }
}
