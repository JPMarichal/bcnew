<?php
namespace App\Services\SocialMedia\Factories;

use App\Services\SocialMedia\Contracts\SocialMediaInterface;
use App\Services\SocialMedia\PinterestService;
use App\Services\SocialMedia\TelegramService;
use App\Services\SocialMedia\TwitterService;
use Illuminate\Support\Facades\App; // Importar la fachada App

class SocialMediaFactory {
    public static function create($type): SocialMediaInterface {
        switch ($type) {
            case 'telegram':
                // Utilizar el contenedor de servicios para resolver la instancia de TelegramService
                return App::make(TelegramService::class);
            case 'pinterest':
                // Utilizar el contenedor de servicios para resolver la instancia de PinterestService
                return App::make(PinterestService::class);
            case 'twitter':
                // Utilizar el contenedor de servicios para resolver la instancia de TwitterService
                return App::make(TwitterService::class);
            // Agregar casos para los demás servicios...
            default:
                throw new \Exception("Servicio de red social no soportado.");
        }
    }
}
