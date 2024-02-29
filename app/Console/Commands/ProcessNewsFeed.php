<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SimpleXMLElement;
use App\Models\NewsItem;
use App\Services\NewsItemMaintenanceService;
use App\Services\NewsTransformerService; 

class ProcessNewsFeed extends Command
{
    protected $signature = 'news:process';
    protected $description = 'Procesa el feed RSS y actualiza la base de datos con las nuevas noticias';

    public function handle()
    {

        $feeds = config('ldsnewsfeeds'); // Carga las configuraciones de feeds de la Sala de Prensa

        foreach ($feeds as $identifier => $config) {
            try {
                // Utiliza la fábrica para obtener el procesador adecuado, pasando la configuración específica del feed
                $processor = \App\Factories\FeedProcessorFactory::make($identifier, $config);
                $processor->processFeed($config['url'], $config); // Asegúrate de que tu procesador de feeds acepte la configuración como segundo argumento
                $this->info("Feed procesado: $identifier");
            } catch (\Exception $e) {
                $this->error("Error procesando el feed $identifier: " . $e->getMessage());
            }
        }

        $feeds = [
            'theChurchNews' => 'http://fetchrss.com/rss/65d7b710bbdeee5bf603688265d7b86c4e20277c58794954.xml',
            'masFe' => 'https://masfe.org/category/noticias/feed/',
            'faroALasNaciones' => 'https://www.faroalasnaciones.com/feed/',
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
        $this->info('Todos los feeds RSS han sido procesados exitosamente.');

        // Llama al servicio de mantenimiento después de procesar todos los feeds
        $maintenanceService = new NewsItemMaintenanceService();
        $maintenanceService->maintainDatabase();
        $this->info('La base de datos ha sido mantenida.');

        // Nuevo código para transformar y guardar las noticias
        $transformerService = new NewsTransformerService();
        $transformerService->transformAndSaveNewsItems();
        $this->info('Las noticias han sido transformadas y guardadas.');
    }
}
