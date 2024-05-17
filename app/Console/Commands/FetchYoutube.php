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
        $monthsBefore = env('MONTHS_BEFORE', 6);
        $cutoffDate = Carbon::now()->subMonths($monthsBefore);

        // Fetch all channels
        $channels = Channel::all();

        foreach ($channels as $channel) {
            $this->info("Procesando canal: {$channel->title}");

            // Fetch playlists from YouTube
            $playlistPageToken = null;
            do {
                $playlistsResponse = $this->youtubeService->getChannelPlaylists($channel->channel_id, $playlistPageToken);
                if (!$playlistsResponse) {
                    $this->error("No se pudo obtener los playlists del canal: {$channel->title}");
                    continue;
                }

                foreach ($playlistsResponse->getItems() as $playlist) {
                    $playlistId = $playlist->getId();
                    $title = $playlist->getSnippet()->getTitle();
                    if (!$title) {
                        $this->error("El título del playlist no está disponible para el playlist con ID: {$playlistId}");
                        continue;
                    }

                    $etag = $playlist->getEtag();

                    $localPlaylist = Playlist::where('playlist_id', $playlistId)->first();

                    if (!$localPlaylist) {
                        // Si el playlist no existe localmente, crearlo y agregar sus videos
                        $localPlaylist = Playlist::create([
                            'playlist_id' => $playlistId,
                            'title' => $title,
                            'channel_id' => $channel->id,
                            'etag' => $etag
                        ]);
                        $this->syncPlaylistVideos($localPlaylist, $etag);
                    } else {
                        // Si el playlist existe, actualizar si es necesario
                        if ($localPlaylist->etag !== $etag) {
                            $localPlaylist->update([
                                'title' => $title,
                                'etag' => $etag
                            ]);
                            $this->syncPlaylistVideos($localPlaylist, $etag);
                        }
                    }
                }

                $playlistPageToken = $playlistsResponse->getNextPageToken();
            } while ($playlistPageToken);
        }

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        $executionTimeMinutes = floor($executionTime / 60);
        $executionTimeSeconds = $executionTime % 60;

        $this->info('Proceso de sincronización completado.');
        $this->info("Tiempo de ejecución: {$executionTimeMinutes} minutos y {$executionTimeSeconds} segundos.");
    }

    private function syncPlaylistVideos($localPlaylist, $etag)
    {
        $this->info("Sincronizando videos del playlist: {$localPlaylist->title}");

        $videoPageToken = null;
        do {
            $videosResponse = $this->youtubeService->getPlaylistVideos($localPlaylist->playlist_id, $videoPageToken);
            if (!$videosResponse) {
                $this->info("No hay actualizaciones para el playlist: {$localPlaylist->title} debido a etag no modificado.");
                return;
            }

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

            $videoPageToken = $videosResponse->getNextPageToken();
        } while ($videoPageToken);
    }
}
