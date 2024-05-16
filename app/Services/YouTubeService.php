<?php

namespace App\Services;

use Google\Client;
use Google\Service\YouTube;

class YoutubeService
{
    protected $client;

    public function __construct()
    {
        $client = new Client();
        $client->setApplicationName("Biblicomentarios");
        $client->setDeveloperKey(env('YOUTUBE_API_KEY'));

        $this->client = new YouTube($client);
    }

    public function getChannelDetails($channelId)
    {
        $params = ['id' => $channelId, 'part' => 'snippet'];
        $response = $this->client->channels->listChannels('snippet', $params);
        return $response->getItems()[0] ?? null;
    }
}
