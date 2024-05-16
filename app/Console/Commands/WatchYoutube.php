<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Video;
use Carbon\Carbon;
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

        // Get the number of months from .env
        $months = env('MONTHS_BEFORE', 6);

        // Calculate the cutoff date
        $cutoffDate = Carbon::now()->subMonths($months);

        // Get all distinct channel_ids with publish_date >= cutoffDate
        $channelIds = Video::select('channel_id')
            ->where('publish_date', '>=', $cutoffDate)
            ->distinct()
            ->pluck('channel_id');

        // Check if there are channel_ids to process
        if ($channelIds->isEmpty()) {
            $this->info('No channels found to update.');
            return;
        }

        $this->info('Number of channels to process: ' . $channelIds->count());

        // Run the fetch:youtube command for each channel_id
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