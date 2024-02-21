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
            $parsedUrl = parse_url($link);
            $source = $parsedUrl['host']; // Obtiene el dominio del link
        
            if (!NewsItem::where('link', $link)->exists()) {
                NewsItem::create([
                    'title' => (string) $item->title,
                    'description' => (string) $item->description,
                    'link' => $link,
                    'pub_date' => (string) $item->pubDate,
                    'author' => (string) $item->author, // Asume que tu feed RSS tiene un elemento <author>
                    'source' => $source, // Usa el dominio como fuente
                    'featured_image' => '',
                    'content' => (string) $item->description,
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
