<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class OpenAIService
{
    protected $client;
    protected $apiKey;
    protected $imageUtilitiesService;

    /**
     * Constructor del servicio OpenAIService.
     * 
     * @param ImageUtilitiesService $imageUtilitiesService Servicio para el manejo de utilidades de imágenes.
     */
    public function __construct(ImageUtilitiesService $imageUtilitiesService)
    {
        $this->apiKey = env('OPENAI_API_KEY');
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
            'timeout' => 30, // Tiempo de espera de 10 segundos para la solicitud
        ]);
        $this->imageUtilitiesService = $imageUtilitiesService;
    }

    /**
     * Obtiene una respuesta de texto del modelo GPT-3.5-turbo basada en un prompt.
     * 
     * @param string $prompt El prompt que se enviará al modelo.
     * @return string La respuesta del modelo o un mensaje de error.
     */
    public function getGPT3TurboTextResponse(string $prompt)
    {
        try {
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
        } catch (GuzzleException $e) {
            return 'Error al conectar con OpenAI: ' . $e->getMessage();
        }
    }

    /**
     * Obtiene una respuesta de texto del modelo GPT-4 basada en un prompt.
     * 
     * @param string $prompt El prompt que se enviará al modelo.
     * @return string La respuesta del modelo o un mensaje de error.
     */
    public function getGPT4TextResponse(string $prompt)
    {
        try {
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
        } catch (GuzzleException $e) {
            return 'Error al conectar con OpenAI: ' . $e->getMessage();
        }
    }

    /**
     * Genera una imagen utilizando el modelo DALL·E 3 basado en un prompt y un selector de tamaño.
     *
     * @param string $prompt Descripción de la imagen deseada.
     * @param string $sizeSelector Selector del tamaño de la imagen. Las opciones son:
     *                             - "cuadrado" para imágenes 1024x1024
     *                             - "horizontal" para imágenes 1792x1024
     *                             - "vertical" para imágenes 1024x1792
     * @return string La ruta pública de la imagen convertida y guardada.
     */
    public function getImage(string $prompt, string $sizeSelector)
    {
        try {
            $size = $this->resolveSize($sizeSelector);

            $response = $this->client->post('https://api.openai.com/v1/images/generations', [
                'json' => [
                    'model' => 'dall-e-3',
                    'prompt' => $prompt,
                    'n' => 1,
                    'size' => $size,
                ]
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);
            $imageUrl = $responseData['data'][0]['url'] ?? null;
            
            if ($imageUrl) {
                return $this->imageUtilitiesService->convertImageFromUrl($imageUrl, 'webp');
            }

            return 'Imagen no disponible';
        } catch (GuzzleException $e) {
            return 'Error al conectar con OpenAI: ' . $e->getMessage();
        }
    }

    /**
     * Resuelve el selector de tamaño a un valor de tamaño compatible con DALL·E 3.
     *
     * @param string $sizeSelector Selector del tamaño.
     * @return string Tamaño de la imagen.
     */
    protected function resolveSize(string $sizeSelector)
    {
        switch ($sizeSelector) {
            case 'cuadrado':
                return '1024x1024';
            case 'horizontal':
                return '1792x1024';
            case 'vertical':
                return '1024x1792';
            default:
                return '1024x1024'; // Valor por defecto si el selector no coincide
        }
    }
}
