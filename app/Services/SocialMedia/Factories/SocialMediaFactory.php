<?php

namespace App\Services\SocialMedia\Factories;

use App\Services\SocialMedia\Contracts\SocialMediaInterface;
use App\Services\SocialMedia\FacebookPageService;
use App\Services\SocialMedia\FacebookGroupService;
use App\Services\SocialMedia\PinterestService;
use App\Services\SocialMedia\TelegramService;
use App\Services\SocialMedia\TwitterService;
use App\Services\SocialMedia\MessengerService;
use App\Services\SocialMedia\WhatsAppBusinessService;
use Illuminate\Support\Facades\App; // Importar la fachada App

class SocialMediaFactory
{
    public static function create($type): SocialMediaInterface
    {
        switch ($type) {
            case 'telegram':
                return App::make(TelegramService::class);
            case 'pinterest':
                return App::make(PinterestService::class);
            case 'twitter':
                return App::make(TwitterService::class);
            case 'facebook_page':
                return App::make(FacebookPageService::class);
            case 'facebook_group':
                return App::make(FacebookGroupService::class);
            case 'messenger':
                return App::make(MessengerService::class);
            case 'whatsapp':
                return App::make(WhatsAppBusinessService::class);
            default:
                throw new \Exception("Servicio de red social no soportado.");
        }
    }
}
