<?php

namespace App\Services;

use Google_Client;
use Google_Service_YouTube;
use Google\Client;
use Google\Service\YouTube;

class YoutubeService
{
    protected $client;

    public function __construct()
    {
        $client = new Client();
        $client->setApplicationName("Biblicomentarios");
        $client->setDeveloperKey(env('YOUTUBE_API_KEY'));  // Usa la clave de API para operaciones públicas

        $this->client = new \Google\Service\YouTube($client);
    }

    public function getChannelVideos($channelId, $pageToken = null)
    {
        $queryParams = [
            'channelId' => $channelId,
            'maxResults' => 25,
            'part' => 'snippet',  // Especifica qué parte de los datos del video se devuelve
            'type' => 'video',    // Especifica que solo se busquen videos
            'pageToken' => $pageToken,
            'order' => 'date'
        ];

        try {
            $response = $this->client->search->listSearch('snippet', $queryParams);
            return $response;
        } catch (\Google\Service\Exception $e) {
            echo 'Error while fetching videos: ' . $e->getMessage();
            return null;
        }
    }
}
