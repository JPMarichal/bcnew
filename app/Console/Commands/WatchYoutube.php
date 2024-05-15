<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Video;
use Illuminate\Support\Facades\Artisan;

class WatchYoutube extends Command
{
    protected $signature = 'watch:youtube';
    protected $description = 'Update all YouTube videos by channel.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Starting to update all YouTube channels...');

        // Recuperar todos los channel_id distintos
        $channelIds = Video::select('channel_id')->distinct()->pluck('channel_id');

        // Verificar si hay channel_ids para procesar
        if ($channelIds->isEmpty()) {
            $this->info('No channels found to update.');
            return;
        }

        // Ejecutar el comando fetch:youtube para cada channel_id
        foreach ($channelIds as $channelId) {
            $this->info("Updating channel: $channelId");
            Artisan::call('fetch:youtube', ['channelId' => $channelId]);
            $this->info("Updated channel: $channelId");
        }

        $this->info('All channels have been updated.');
    }
}
