<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\YoutubeService;
use App\Models\Channel;
use App\Models\Playlist;
use App\Models\Video;
use Carbon\Carbon;

class FetchYoutube extends Command
{
    protected $signature = 'fetch:youtube';
    protected $description = 'Fetches updates from YouTube channels and synchronizes playlists and videos.';

    private $youtubeService;

    public function __construct()
    {
        parent::__construct();
        $this->youtubeService = new YoutubeService();
    }

    public function handle()
    {
        $startTime = microtime(true);
        $this->info('Inicio del proceso de sincronización.');
        $monthsBefore = env('MONTHS_BEFORE');
        $cutoffDate = Carbon::now()->subMonths($monthsBefore);

        // Fetch channels that have videos published within the last 'monthsBefore' months
        $channels = Channel::whereHas('playlists.videos', function ($query) use ($cutoffDate) {
            $query->where('publish_date', '>=', $cutoffDate);
        })->get();

        // Indica al usuario cuántos canales se procesarán
        $this->info("Se procesarán {$channels->count()} canales.");

        foreach ($channels as $channel) {
            $this->info("Procesando canal: {$channel->title}");

            // Fetch playlists from YouTube
            $playlistsResponse = $this->youtubeService->getChannelPlaylists($channel->channel_id);
            if (!$playlistsResponse) {
                $this->error("No se pudo obtener los playlists del canal: {$channel->title}");
                continue;
            }

            foreach ($playlistsResponse->getItems() as $playlist) {
                $title = $playlist->getSnippet()->getTitle();
                if (!$title) {
                    $this->error("El título del playlist no está disponible para el playlist con ID: {$playlist->getId()}");
                    continue;
                }

                $localPlaylist = Playlist::updateOrCreate(
                    ['playlist_id' => $playlist->getId()],
                    [
                        'title' => $title,
                        'channel_id' => $channel->id,
                        'etag' => $playlist->getEtag()
                    ]
                );

                // Check for video updates if etag has changed
                if ($localPlaylist->wasChanged('etag')) {
                    $this->info("- Actualizando los videos del playlist: {$title}");
                    $videosResponse = $this->youtubeService->getPlaylistVideos($localPlaylist->playlist_id, null, $localPlaylist->etag);

                    if ($videosResponse) {
                        // Sync videos
                        foreach ($videosResponse->getItems() as $videoYT) {
                            $snippet = $videoYT->getSnippet();
                            $contentDetails = $videoYT->getContentDetails();
                            $status = $videoYT->getStatus();

                            // Solo considerar videos públicos
                            if ($status->getPrivacyStatus() != 'public') {
                                continue;
                            }

                            $thumbnail = $snippet->getThumbnails()->getDefault();
                            $thumbnailUrl = $thumbnail ? $thumbnail->getUrl() : null;

                            Video::updateOrCreate(
                                ['video_id' => $contentDetails->getVideoId()],
                                [
                                    'playlist_id' => $localPlaylist->id,
                                    'title' => $snippet->getTitle(),
                                    'description' => $snippet->getDescription(),
                                    'video_url' => 'https://www.youtube.com/watch?v=' . $contentDetails->getVideoId(),
                                    'thumbnail_url' => $thumbnailUrl,
                                    'publish_date' => $contentDetails->getVideoPublishedAt() ? Carbon::parse($contentDetails->getVideoPublishedAt())->toDateTimeString() : null
                                ]
                            );
                        }
                    } else {
                        $this->info("No hay actualizaciones para el playlist: {$playlist->getSnippet()->getTitle()} debido a etag no modificado.");
                    }
                }
            }
        }

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        $executionTimeMinutes = floor($executionTime / 60);
        $executionTimeSeconds = $executionTime % 60;

        $this->info('Proceso de sincronización completado.');
        $this->info("Tiempo de ejecución: {$executionTimeMinutes} minutos y {$executionTimeSeconds} segundos.");
    }
}
