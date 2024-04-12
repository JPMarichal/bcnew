<?php
namespace App\Services\SocialMedia;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class FacebookGroupService
{
    protected $client;
    protected $groupAccessToken;
    protected $groupId;

    public function __construct()
    {
        $this->client = new Client();
        $this->groupAccessToken = Config::get('services.facebook.facebook_group_access_token');
        $this->groupId = 'tu_group_id'; // Reemplaza esto con el ID real de tu grupo de Facebook
    }

    public function postMessage($message)
    {
        $url = "https://graph.facebook.com/{$this->groupId}/feed";
        $params = [
            'form_params' => [
                'message' => $message,
                'access_token' => $this->groupAccessToken,
            ]
        ];

        $response = $this->client->post($url, $params);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function postImage($imagePath, $message = '')
    {
        $url = "https://graph.facebook.com/{$this->groupId}/photos";
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
                'access_token' => $this->groupAccessToken,
            ]
        ];

        $response = $this->client->post($url, $params);
        return json_decode($response->getBody()->getContents(), true);
    }
}
