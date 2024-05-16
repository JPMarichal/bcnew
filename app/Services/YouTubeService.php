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

    public function getChannelPlaylists($channelId, $pageToken = null)
    {
        $params = [
            'channelId' => $channelId,
            'maxResults' => 25,
            'part' => 'snippet,contentDetails',
            'pageToken' => $pageToken
        ];

        try {
            return $this->client->playlists->listPlaylists('snippet,contentDetails', $params);
        } catch (\Google\Service\Exception $e) {
            // Puedes manejar los errores o simplemente lanzarlos
            throw new \Exception('Failed to fetch playlists: ' . $e->getMessage());
        }
    }

    public function getPlaylistVideos($playlistId, $pageToken = null)
    {
        $params = [
            'playlistId' => $playlistId,
            'maxResults' => 25,
            'part' => 'snippet,contentDetails,status',
            'pageToken' => $pageToken
        ];

        try {
            $response = $this->client->playlistItems->listPlaylistItems('snippet,contentDetails,status', $params);
            return $response;
        } catch (\Google\Service\Exception $e) {
            throw new \Exception('Failed to fetch videos: ' . $e->getMessage());
        }
    }
}
