<?php
namespace App\Services\SocialMedia;

use App\Services\SocialMedia\Contracts\SocialMediaInterface;
use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client;

class WhatsAppBusinessService implements SocialMediaInterface
{
    protected $client;
    protected $token;
    protected $phoneNumberId;

    public function __construct()
    {
        $this->client = new Client();
        $this->token = Config::get('services.whatsapp.whatsapp_bussiness_token');
        $this->phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID'); // ¿Cómo obtenerlo?
    }

    public function postMessage($message)
    {
        // Enviar un mensaje de texto simple a través de WhatsApp Business API
        $url = "https://graph.facebook.com/v13.0/{$this->phoneNumberId}/messages";
        $params = [
            'headers' => ['Authorization' => 'Bearer ' . $this->token],
            'json' => [
                'messaging_product' => 'whatsapp',
                'to' => 'RECIPIENT_PHONE_NUMBER',
                'type' => 'text',
                'text' => ['body' => $message],
            ],
        ];

        return $this->client->post($url, $params);
    }

    public function postImage($imagePath)
    {
        // Enviar una imagen requiere primero subir el archivo para obtener un ID de media
        // Este método se omite aquí por simplicidad y porque la implementación exacta varía.
    }

    public function postMessageWithImage($message, $imagePath)
    {
        // WhatsApp no soporta directamente el envío de un mensaje con texto e imagen juntos en una sola API call
        // Necesitarías implementar una lógica para primero subir la imagen, obtener el media ID, y luego enviarla con un mensaje.
    }
}
