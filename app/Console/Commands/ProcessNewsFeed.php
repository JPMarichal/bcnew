<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SimplePie;
use App\Models\NewsItem;

class ProcessNewsFeed extends Command
{
    protected $signature = 'news:process';
    protected $description = 'Procesa el feed RSS y actualiza la base de datos con las nuevas noticias';

    public function handle()
    {
        $feed = new SimplePie();
        $feed->set_feed_url('https://feed.informer.com/digests/1ETKMRWFSY/feeder.rss');
        $feed->init();

        foreach ($feed->get_items() as $item) {
            $link = $item->get_permalink();
            // Verificar si la noticia ya existe por URL
            if (!NewsItem::where('link', $link)->exists()) {
                NewsItem::create([
                    'title' => $item->get_title(),
                    'description' => $item->get_description(),
                    'link' => $link,
                    'pub_date' => $item->get_date('Y-m-d H:i:s'),
                    'source' => 'Nombre de la fuente', // Ajusta según necesidad
                    'featured_image' => '', // Ajusta según necesidad
                    'content' => $item->get_content(), // o algún campo equivalente
                ]);
            }
        }

        // Implementar lógica para mantener el límite de registros
        while (NewsItem::count() > 1000) {
            // Eliminar el registro más antiguo
            NewsItem::orderBy('pub_date', 'asc')->first()->delete();
        }

        $this->info('Feed RSS procesado exitosamente.');
    }
}
