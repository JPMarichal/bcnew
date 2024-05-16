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
        $startTime = microtime(true);
        $this->info('Starting to update all YouTube channels at ' . date('H:i:s', $startTime));

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
        }

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        $executionTimeMinutes = floor($executionTime / 60);
        $executionTimeSeconds = $executionTime % 60;

        $this->info('All channels have been updated at ' . date('H:i:s', $endTime));
        $this->info("Execution time: $executionTimeMinutes minutes and $executionTimeSeconds seconds.");
    }
}