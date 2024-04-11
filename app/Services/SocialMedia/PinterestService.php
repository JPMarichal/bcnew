<?php
namespace App\Services\SocialMedia;

use App\Services\SocialMedia\Contracts\SocialMediaInterface;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\Config;

class PinterestService implements SocialMediaInterface
{
    protected $client;
    protected $accessToken;
    protected $boardId;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        $this->accessToken = Config::get('services.pinterest.access_token');
        $this->boardId = Config::get('services.pinterest.board_id');
    }

    public function postMessage($message)
    {
        // Implementación específica si es necesaria
    }

    public function postImage($imagePath)
    {
        // Implementación específica si es necesaria
    }

    public function postMessageWithImage($message, $imagePath)
    {
        $url = 'https://api.pinterest.com/v5/pins/';
        
        try {
            $response = $this->client->request('POST', $url, [
                'headers' => [
                    'Authorization' => "Bearer {$this->accessToken}",
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'board_id' => $this->boardId,
                    'note' => $message,
                    'image_url' => $imagePath,
                    // 'link' => 'optional_link_if_you_need' // Descomentar y reemplazar si es necesario
                ]
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            // Aquí deberías manejar el error como mejor convenga a tu aplicación
            throw new \Exception("Error al publicar en Pinterest: " . $e->getMessage());
        }
    }
}
