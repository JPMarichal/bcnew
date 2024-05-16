<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Playlist;
use App\Models\Video;
use App\Services\YoutubeService;

class VideoSeeder extends Seeder
{
    public function run()
    {
        $youtubeService = new YoutubeService();
        $playlists = Playlist::all();

        foreach ($playlists as $playlist) {
            $videoPageToken = null;
            do {
                $videosResponse = $youtubeService->getPlaylistVideos($playlist->playlist_id, $videoPageToken);

                foreach ($videosResponse->getItems() as $videoItem) {
                    // Check if the video is public
                    if ($videoItem->getStatus()->getPrivacyStatus() == 'public') {
                        Video::updateOrCreate(
                            ['video_id' => $videoItem->getContentDetails()->getVideoId()],
                            [
                                'playlist_id' => $playlist->id,
                                'title' => $videoItem->getSnippet()->getTitle(),
                                'description' => $videoItem->getSnippet()->getDescription(),
                                'video_url' => 'https://www.youtube.com/watch?v=' . $videoItem->getContentDetails()->getVideoId(),
                                'thumbnail_url' => $videoItem->getSnippet()->getThumbnails()->getDefault()->getUrl(),
                                'publish_date' => new \DateTime($videoItem->getContentDetails()->getVideoPublishedAt())
                            ]
                        );
                    }
                }

                $videoPageToken = $videosResponse->getNextPageToken();
            } while ($videoPageToken);
        }
    }
}
