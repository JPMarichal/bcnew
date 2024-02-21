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
        $feeds = [
          //  'default' => 'https://feed.informer.com/digests/1ETKMRWFSY/feeder.rss',
            'hondurasNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=honduras',
            // Añade más feeds aquí con sus identificadores respectivos
        ];

        foreach ($feeds as $identifier => $url) {
            try {
                $processor = \App\Factories\FeedProcessorFactory::make($identifier);
                $processor->processFeed($url);
                $this->info("Feed procesado: $identifier");
            } catch (\Exception $e) {
                $this->error("Error procesando el feed $identifier: " . $e->getMessage());
            }
        }

        // Lógica para mantener el límite de registros, si es necesario

        $this->info('Todos los feeds RSS han sido procesados exitosamente.');
    }
}