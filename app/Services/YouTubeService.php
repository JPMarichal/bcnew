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

    public function getChannelPlaylists($channelId, $pageToken = null)
    {
        $params = [
            'channelId' => $channelId,
            'maxResults' => 25,
            'part' => 'snippet,contentDetails',
            'pageToken' => $pageToken
        ];

        return $this->client->playlists->listPlaylists('snippet,contentDetails', $params);
    }

    public function getPlaylistItems($playlistId, $pageToken = null, $etag = null)
    {
        $params = [
            'playlistId' => $playlistId,
            'maxResults' => 25,
            'part' => 'snippet,contentDetails',
            'pageToken' => $pageToken
        ];

        $optParams = [];

        if ($etag) {
            $optParams['headers'] = ['If-None-Match' => $etag];
        }

        return $this->client->playlistItems->listPlaylistItems('snippet,contentDetails', $params, $optParams);
    }

    public function getChannelDetails($channelId)
    {
        $params = [
            'id' => $channelId,
            'part' => 'snippet'
        ];

        $response = $this->client->channels->listChannels('snippet', $params);

        if ($response->getItems()) {
            return $response->getItems()[0];
        }

        return null;
    }
}
