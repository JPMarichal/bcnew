<?php
namespace App\Factories;

use App\Contracts\FeedProcessorInterface;
use App\Services\FeedProcessors\LdsNewsFeedProcessor;
use App\Services\FeedProcessors\DefaultFeedProcessor;
use App\Services\FeedProcessors\MasFeNewsFeedProcessor;
use App\Services\FeedProcessors\FaroALasNacionesFeedProcessor;
use App\Services\FeedProcessors\ZonaMormonNewsFeedProcessor;
use App\Services\FeedProcessors\TheChurchNewsFeedProcessor;
// Importaciones adicionales si son necesarias

class FeedProcessorFactory
{
    public static function make(string $feedIdentifier): FeedProcessorInterface
    {
        // Carga la configuración de feeds LDS desde el archivo de configuración
        $ldsNewsFeedsConfig = config('ldsnewsfeeds');

        if (array_key_exists($feedIdentifier, $ldsNewsFeedsConfig)) {
            // Extrae la configuración específica para el feed
            $feedConfig = $ldsNewsFeedsConfig[$feedIdentifier];
            // Extrae país e idioma de la configuración
            $country = $feedConfig['country'];
            $language = $feedConfig['language'] ; 
            $source = $feedConfig['source'];
            
            // Retorna una instancia del procesador dinámico para los feeds LDS, pasando país e idioma
            return new LdsNewsFeedProcessor($country, $language, $source);
        } else {
            // Lógica existente para seleccionar procesadores de feeds específicos
            switch ($feedIdentifier) {
                case 'masFe':
                    return new MasFeNewsFeedProcessor();
                case 'faroALasNaciones':
                    return new FaroALasNacionesFeedProcessor();
                case 'theChurchNews':
                    return new TheChurchNewsFeedProcessor();
                // Agrega aquí más casos para otros dominios con procesadores específicos
                default:
                    throw new \Exception("No hay procesador disponible para: " . $feedIdentifier);
            }
        }
    }
}
