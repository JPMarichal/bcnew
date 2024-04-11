<?php

namespace App\Services\SocialMedia;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Services\SocialMedia\Contracts\SocialMediaInterface;
use Illuminate\Support\Facades\Config;

class TwitterService implements SocialMediaInterface
{
    protected $twitter;

    public function __construct()
    {
        $this->twitter = new TwitterOAuth(
            Config::get('services.twitter.api_key'),
            Config::get('services.twitter.api_secret_key'),
            Config::get('services.twitter.access_token'),
            Config::get('services.twitter.access_token_secret')
        );
    }

    public function postMessage($message)
    {
        try {
            $this->twitter->post("statuses/update", ["status" => $message]);
        } catch (\Exception $e) {
            // Manejo de la excepción
            throw new \Exception("Error al publicar mensaje en Twitter: " . $e->getMessage());
        }
    }

    public function postImage($imagePath)
    {
        try {
            // Primero, subimos la imagen a Twitter y obtenemos su media_id
            $uploadedMedia = $this->twitter->upload('media/upload', ['media' => $imagePath]);
            // Luego, publicamos un tweet con esa imagen usando su media_id
            $this->twitter->post("statuses/update", ["media_ids" => $uploadedMedia->media_id_string]);
        } catch (\Exception $e) {
            // Manejo de la excepción
            throw new \Exception("Error al publicar imagen en Twitter: " . $e->getMessage());
        }
    }

    public function postMessageWithImage($message, $imagePath)
    {
        try {
            // Subimos la imagen a Twitter y obtenemos su media_id
            $uploadedMedia = $this->twitter->upload('media/upload', ['media' => $imagePath]);
            // Publicamos un tweet con mensaje y la imagen usando su media_id
            $this->twitter->post("statuses/update", ["status" => $message, "media_ids" => $uploadedMedia->media_id_string]);
        } catch (\Exception $e) {
            // Manejo de la excepción
            throw new \Exception("Error al publicar mensaje con imagen en Twitter: " . $e->getMessage());
        }
    }
}
