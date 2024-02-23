<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsItemMaintenanceService;

class ProcessNewsFeed extends Command
{
    protected $signature = 'news:process';
    protected $description = 'Procesa el feed RSS y actualiza la base de datos con las nuevas noticias';

    public function handle()
    {
        $feeds = [
            //  'default' => 'https://feed.informer.com/digests/1ETKMRWFSY/feeder.rss',
          /*  'theChurchNews' => 'http://fetchrss.com/rss/65d7b710bbdeee5bf603688265d7b86c4e20277c58794954.xml',
            'peruNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=peru',
            'boliviaNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=bolivia',
            'hondurasNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=honduras',
            'mexicoNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=mexico',
            'argentinaNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=argentina',
            'chileNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=chile',
            'costaRicaNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=costa-rica',
            'colombiaNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=colombia',
            'ecuadorNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=ecuador',
            'elSalvadorNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=el-salvador',
            'españaNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=spain',
            'usaEspañolNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=spanish',
            'guatemalaNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=guatemala',
            'nicaraguaNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=nicaragua',
            'panamaNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=panamá',
            'paraguayNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=paraguay',
            'puertoRicoNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=puerto-rico',
            'republicaDominicanaNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=dominican-republic',
            'uruguayNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=uruguay',
            'venezuelaNews' => 'https://noticias.laiglesiadejesucristo.org/rss?country=venezuela',*/
            'faroALasNaciones' => 'https://www.faroalasnaciones.com/feed/',
        /*    'zonaMormon' => 'https://zonamormon.wordpress.com/feed/',
            'masFe' => 'https://masfe.org/category/noticias/feed/', */

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

        // Llama al servicio de mantenimiento después de procesar todos los feeds
        $maintenanceService = new NewsItemMaintenanceService();
        $maintenanceService->maintainDatabase();

        $this->info('Todos los feeds RSS han sido procesados exitosamente y la base de datos ha sido mantenida.');
    }
}
