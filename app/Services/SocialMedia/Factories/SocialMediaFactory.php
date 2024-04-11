<?php
namespace App\Services\SocialMedia\Factories;

use App\Services\SocialMedia\Contracts\SocialMediaInterface;
use App\Services\SocialMedia\FacebookService;
use App\Services\SocialMedia\TelegramService;

// Importar los demás servicios...

class SocialMediaFactory {
    public static function create($type): SocialMediaInterface {
        switch ($type) {
            case 'telegram':
                return new TelegramService();
            // Agregar casos para los demás servicios...
            default:
                throw new \Exception("Servicio de red social no soportado.");
        }
    }
}
