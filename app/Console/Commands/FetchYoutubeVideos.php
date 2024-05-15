<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\YoutubeService;
use App\Models\Video;
use Carbon\Carbon;

class FetchYoutubeVideos extends Command
{
    protected $signature = 'fetch:youtube {channelId}';
    protected $description = 'Fetches playlists and their videos from a specified YouTube channel and stores them in the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $channelId = $this->argument('channelId');
        $youtubeService = new YoutubeService();
        
        // Obteniendo los detalles del canal antes de procesar los playlists
        $channelDetails = $youtubeService->getChannelDetails($channelId);
        if (!$channelDetails) {
            $this->error("Failed to retrieve channel details for channel ID: {$channelId}");
            return;
        }

        $userId = $channelDetails->getId();
        $userName = $channelDetails->getSnippet()->getTitle();
        $language = $channelDetails->getSnippet()->getDefaultLanguage() ?? 'es';

        $playlistPageToken = null;

        do {
            $playlistsResponse = $youtubeService->getChannelPlaylists($channelId, $playlistPageToken);

            foreach ($playlistsResponse->getItems() as $playlist) {
                $playlistId = $playlist->getId();
                $videoPageToken = null;
                $etag = $playlist->getEtag();

                do {
                    $videosResponse = $youtubeService->getPlaylistItems($playlistId, $videoPageToken, $etag);

                    if ($videosResponse === null) {
                        $this->info("No updates for playlist {$playlistId} due to unchanged etag.");
                        continue;
                    }

                    foreach ($videosResponse->getItems() as $videoYT) {
                        $thumbnail = $videoYT->getSnippet()->getThumbnails()->getDefault();
                        $thumbnailUrl = $thumbnail ? $thumbnail->getUrl() : null;
                    
                        $videoData = [
                            'video_id' => $videoYT->getContentDetails()->getVideoId(),
                            'video_url' => 'https://www.youtube.com/watch?v=' . $videoYT->getContentDetails()->getVideoId(),
                            'title' => $videoYT->getSnippet()->getTitle(),
                            'description' => $videoYT->getSnippet()->getDescription(),
                            'channel_id' => $channelId,
                            'channel_title' => $userName,
                            'playlist_id' => $playlistId,
                            'playlist_title' => $playlist->getSnippet()->getTitle(),
                            'publish_date' => $videoYT->getContentDetails()->getVideoPublishedAt() ? Carbon::parse($videoYT->getContentDetails()->getVideoPublishedAt())->toDateTimeString() : null,
                            'thumbnail_url' => $thumbnailUrl,
                            'language' => $language,
                            'etag' => $etag,
                            'user_id' => $userId,
                            'user_name' => $userName
                        ];
                    
                        Video::updateOrCreate(
                            ['video_id' => $videoData['video_id']],
                            $videoData
                        );
                    }                    

                    $videoPageToken = $videosResponse ? $videosResponse->getNextPageToken() : null;
                } while ($videoPageToken);

                $playlistPageToken = $playlistsResponse->getNextPageToken();
            }
        } while ($playlistPageToken);

        $this->info('All playlists and their videos have been fetched and stored.');
    }
}
