<?php

namespace App\Factories;

use App\Contracts\FeedProcessorInterface;
use App\Services\FeedProcessors\DefaultFeedProcessor;
use App\Services\FeedProcessors\ArgentinaNewsFeedProcessor;
use App\Services\FeedProcessors\BoliviaNewsFeedProcessor;
use App\Services\FeedProcessors\ChileNewsFeedProcessor;
use App\Services\FeedProcessors\ColombiaNewsFeedProcessor;
use App\Services\FeedProcessors\CostaRicaNewsFeedProcessor;
use App\Services\FeedProcessors\EcuadorNewsFeedProcessor;
use App\Services\FeedProcessors\ElSalvadorNewsFeedProcessor;
use App\Services\FeedProcessors\EspañaNewsFeedProcessor;
use App\Services\FeedProcessors\GuatemalaNewsFeedProcessor;
use App\Services\FeedProcessors\HondurasNewsFeedProcessor;
use App\Services\FeedProcessors\MexicoNewsFeedProcessor;
use App\Services\FeedProcessors\NicaraguaNewsFeedProcessor;
use App\Services\FeedProcessors\PanamaNewsFeedProcessor;
use App\Services\FeedProcessors\ParaguayNewsFeedProcessor;
use App\Services\FeedProcessors\PeruNewsFeedProcessor;
use App\Services\FeedProcessors\PuertoRicoNewsFeedProcessor;
use App\Services\FeedProcessors\RepublicaDominicanaNewsFeedProcessor;
use App\Services\FeedProcessors\UruguayNewsFeedProcessor;
use App\Services\FeedProcessors\USAEspañolNewsFeedProcessor;
use App\Services\FeedProcessors\VenezuelaNewsFeedProcessor;
use App\Services\FeedProcessors\TheChurchNewsFeedProcessor;
use App\Services\FeedProcessors\FaroALasNacionesFeedProcessor;

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
            case 'argentinaNews':
                return new ArgentinaNewsFeedProcessor();
            case 'boliviaNews':
                return new BoliviaNewsFeedProcessor();
            case 'chileNews':
                return new ChileNewsFeedProcessor();
            case 'colombiaNews':
                return new ColombiaNewsFeedProcessor();
            case 'costaRicaNews':
                return new CostaRicaNewsFeedProcessor();
            case 'ecuadorNews':
                return new EcuadorNewsFeedProcessor();
            case 'elSalvadorNews':
                return new ElSalvadorNewsFeedProcessor();
            case 'españaNews':
                return new EspañaNewsFeedProcessor();
            case 'guatemalaNews':
                return new GuatemalaNewsFeedProcessor();
            case 'hondurasNews':
                return new HondurasNewsFeedProcessor();
            case 'mexicoNews':
                return new MexicoNewsFeedProcessor();
            case 'nicaraguaNews':
                return new NicaraguaNewsFeedProcessor();
            case 'panamaNews':
                return new PanamaNewsFeedProcessor();
            case 'paraguayNews':
                return new ParaguayNewsFeedProcessor();
            case 'peruNews':
                return new PeruNewsFeedProcessor();
            case 'puertoRicoNews':
                return new PuertoRicoNewsFeedProcessor();
            case 'republicaDominicanaNews':
                return new RepublicaDominicanaNewsFeedProcessor();
            case 'uruguayNews':
                return new UruguayNewsFeedProcessor();
            case 'usaEspañolNews':
                return new USAEspañolNewsFeedProcessor();
            case 'venezuelaNews':
                return new VenezuelaNewsFeedProcessor();
            case 'theChurchNews':
                return new TheChurchNewsFeedProcessor();
            case 'faroALasNaciones':
                return new FaroALasNacionesFeedProcessor();

                // Aquí puedes añadir más casos para otros procesadores de feed específicos
            default:
                throw new \Exception("No feed processor available for: " . $feedIdentifier);
        }
    }
}
