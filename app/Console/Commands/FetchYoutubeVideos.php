<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\YoutubeService;
use App\Models\Video;
use Carbon\Carbon;

class FetchYoutubeVideos extends Command
{
    protected $signature = 'fetch:youtube {channelId}';
    protected $description = 'Fetches all videos from a specified YouTube channel and stores them in the database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $channelId = $this->argument('channelId');
        $youtubeService = new YoutubeService();
        $pageToken = null;

        do {
            $response = $youtubeService->getChannelVideos($channelId, $pageToken);

            foreach ($response->getItems() as $item) {
                $publishDate = new Carbon($item->getSnippet()->getPublishedAt()); // Convierte la fecha ISO 8601 a un objeto Carbon

                $videoData = [
                    'title' => $item->getSnippet()->getTitle(),
                    'video_id' => $item->getId()->getVideoId(),
                    'description' => $item->getSnippet()->getDescription(),
                    'platform' => 'youtube',
                    'video_url' => 'https://www.youtube.com/watch?v=' . $item->getId()->getVideoId(),
                    'publish_date' => $publishDate->toDateTimeString(), // Convierte a formato de fecha y hora MySQL
                    'user_name' => $item->getSnippet()->getChannelTitle(),
                    'user_id' => $item->getSnippet()->getChannelId(),
                    'likes_count' => 0, // YouTube API no proporciona esto directamente en listSearch
                    'comments_count' => 0, // YouTube API no proporciona esto directamente en listSearch
                    'shares_count' => 0, // YouTube API no proporciona esto directamente en listSearch
                   // 'hashtags' => implode(',', $item->getSnippet()->getTags() ?? []),
                    'thumbnail_url' => $item->getSnippet()->getThumbnails()->getHigh()->getUrl(),
                    'video_duration' => 0 // YouTube API no proporciona esto directamente en listSearch
                ];

                Video::updateOrCreate(
                    ['video_id' => $videoData['video_id'], 'platform' => 'youtube'],
                    $videoData
                );
            }

            $pageToken = $response->getNextPageToken();
        } while ($pageToken);

        $this->info('All videos have been fetched and stored.');
    }
}
