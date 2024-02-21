<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SimpleXMLElement;
use App\Models\NewsItem;

class ProcessNewsFeed extends Command
{
    protected $signature = 'news:process';
    protected $description = 'Procesa el feed RSS y actualiza la base de datos con las nuevas noticias';

    public function handle()
    {
        $feedUrl = 'https://feed.informer.com/digests/1ETKMRWFSY/feeder.rss';
        $feed = simplexml_load_file($feedUrl);

        foreach ($feed->channel->item as $item) {
            $link = (string) $item->link;
            if (!NewsItem::where('link', $link)->exists()) {
                NewsItem::create([
                    'title' => (string) $item->title,
                    'description' => (string) $item->description,
                    'link' => $link,
                    'pub_date' => (string) $item->pubDate,
                    'source' => (string) $item->author,
                    'featured_image' => '',
                    'content' => (string) $item->description, // Ajustar según la estructura del feed
                ]);
            }
        }

        // Lógica para mantener el límite de registros
        while (NewsItem::count() > 1000) {
            NewsItem::orderBy('pub_date', 'asc')->first()->delete();
        }

        $this->info('Feed RSS procesado exitosamente.');
    }
}
