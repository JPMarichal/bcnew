<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenAIService
{
    protected $client;
    protected $apiKey;
    protected $imageUtilitiesService;

    public function __construct(ImageUtilitiesService $imageUtilitiesService)
    {
        $this->apiKey = env('OPENAI_API_KEY');
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ]
        ]);
        $this->imageUtilitiesService = $imageUtilitiesService;
    }

    public function getGPT3TurboTextResponse(string $prompt)
    {
        $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);
        return $responseData['choices'][0]['message']['content'] ?? 'Respuesta no disponible';
    }

    public function getGPT4TextResponse(string $prompt)
    {
        $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
            'json' => [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
                'max_tokens' => 256,
                'top_p' => 1,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ]
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);
        return $responseData['choices'][0]['message']['content'] ?? 'Respuesta no disponible';
    }

    public function getImage(string $prompt)
    {
        $response = $this->client->post('https://api.openai.com/v1/images/generations', [
            'json' => [
                'model' => 'dall-e-3',
                'prompt' => $prompt,
                'n' => 1,
                'size' => '1024x1024',
            ]
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);
        $imageUrl = $responseData['data'][0]['url'] ?? null;
        
        if ($imageUrl) {
            return $this->imageUtilitiesService->convertImageFromUrl($imageUrl, 'webp');
        }

        return 'Imagen no disponible';
    }
}
