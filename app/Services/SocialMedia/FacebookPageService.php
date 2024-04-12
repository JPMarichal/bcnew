<?php
namespace App\Services\SocialMedia;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class FacebookPageService
{
    protected $client;
    protected $pageAccessToken;
    protected $pageId;

    public function __construct()
    {
        $this->client = new Client();
        $this->pageAccessToken = Config::get('services.facebook.facebook_page_access_token');
        $this->pageId = 'tu_page_id'; // Reemplaza esto con el ID real de tu página de Facebook
    }

    public function postMessage($message)
    {
        $url = "https://graph.facebook.com/{$this->pageId}/feed";
        $params = [
            'query' => [
                'message' => $message,
                'access_token' => $this->pageAccessToken,
            ]
        ];

        $response = $this->client->post($url, $params);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function postImage($imagePath, $message = '')
    {
        $url = "https://graph.facebook.com/{$this->pageId}/photos";
        $params = [
            'multipart' => [
                [
                    'name' => 'message',
                    'contents' => $message
                ],
                [
                    'name'     => 'source',
                    'contents' => fopen($imagePath, 'r')
                ]
            ],
            'query' => [
                'access_token' => $this->pageAccessToken,
            ]
        ];

        $response = $this->client->post($url, $params);
        return json_decode($response->getBody()->getContents(), true);
    }
}
