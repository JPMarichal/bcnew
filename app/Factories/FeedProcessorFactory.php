<?php

namespace App\Factories;

use App\Contracts\FeedProcessorInterface;
use App\Services\FeedProcessors\DefaultFeedProcessor;
use App\Services\FeedProcessors\HondurasNewsFeedProcessor;
// Asegúrate de importar todas las clases de procesadores de feed necesarias

class FeedProcessorFactory
{
    /**
     * Crea y devuelve una instancia del procesador de feed adecuado.
     *
     * @param string $feedIdentifier Identificador único para cada feed.
     * @return FeedProcessorInterface
     * @throws \Exception Si no se encuentra un procesador para el identificador dado.
     */
    public static function make(string $feedIdentifier): FeedProcessorInterface
    {
        switch ($feedIdentifier) {
            case 'default':
                return new DefaultFeedProcessor();
            case 'hondurasNews':
                return new HondurasNewsFeedProcessor();
            // Aquí puedes añadir más casos para otros procesadores de feed específicos
            default:
                throw new \Exception("No feed processor available for: " . $feedIdentifier);
        }
    }
}
