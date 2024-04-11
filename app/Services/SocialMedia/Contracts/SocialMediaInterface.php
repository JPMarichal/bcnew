<?php
namespace App\Services\SocialMedia\Contracts;

interface SocialMediaInterface {
    public function postMessage($message);
    public function postImage($imagePath);
    public function postMessageWithImage($message, $imagePath);
}
