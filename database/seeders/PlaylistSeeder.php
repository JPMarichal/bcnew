<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Channel;
use App\Models\Playlist;
use App\Services\YoutubeService;

class PlaylistSeeder extends Seeder
{
    public function run()
    {
        $youtubeService = new YoutubeService();
        $channels = Channel::all();  // Esto recupera todos los registros de la tabla channels

        foreach ($channels as $channel) {
            $playlistPageToken = null;
            do {
                $playlistsResponse = $youtubeService->getChannelPlaylists($channel->channel_id, $playlistPageToken); // Utiliza el channel_id de YouTube para la API
                foreach ($playlistsResponse->getItems() as $playlist) {
                    Playlist::updateOrCreate(
                        ['playlist_id' => $playlist->getId()], // Utiliza el ID de playlist de YouTube para identificar de manera única
                        [
                            'channel_id' => $channel->id, // Usa el id interno de la tabla channels
                            'title' => $playlist->getSnippet()->getTitle(),
                            'etag' => $playlist->getEtag()
                        ]
                    );
                }
                $playlistPageToken = $playlistsResponse->getNextPageToken();
            } while ($playlistPageToken);
        }
    }
}
