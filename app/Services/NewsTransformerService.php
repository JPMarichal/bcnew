<?php

namespace App\Services;

use App\Models\NewsItem;
use App\Models\NewsPost;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewsTransformerService
{
    private $openAiApiKey;
    private $httpClient;

    public function __construct()
    {
        $this->openAiApiKey = env('OPENAI_API_KEY');
        $this->httpClient = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function transformAndSaveNewsItems()
    {
        $newsItems = NewsItem::whereNotIn('link', NewsPost::pluck('link_original'))->get();

        $promises = $newsItems->map(function ($newsItem) {
            return $this->transformNewsItemAsync($newsItem);
        })->all();

        // Esperar a que todas las promesas se completen
        \GuzzleHttp\Promise\Utils::all($promises)->wait();
    }

    private function transformNewsItemAsync(NewsItem $newsItem): PromiseInterface
    {
        $contentPromise = $this->callOpenAIAsync($this->generatePrompt($newsItem->content, 'content'), 1024);

        return $contentPromise->then(
            function ($response) use ($newsItem) {
                $responseData = json_decode($response->getBody(), true);
                $transformedContent = $responseData['choices'][0]['text'];

                $title = $this->generateTitle($newsItem->content);
                $description = $this->generateDescription($newsItem->content);

                $this->saveTransformedNewsItem([
                    'title' => $title,
                    'description' => $description,
                    'slug' => Str::slug($title),
                    'content' => $transformedContent,
                ], $newsItem);
            }
        );
    }

    private function callOpenAIAsync(string $prompt, int $maxTokens): PromiseInterface
    {
        return $this->httpClient->postAsync('https://api.openai.com/v1/chat/completions', [
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [["role" => "user", "content" => $prompt]],
                'temperature' => 0.7,
                'max_tokens' => $maxTokens,
            ]
        ]);
    }

    private function generatePrompt(string $content, string $type): string
    {
        switch ($type) {
            case 'title':
                return "Basándote en el contenido proporcionado, que trata sobre eventos y actividades de La Iglesia de Jesucristo de los Santos de los Últimos Días, crea un título en español que sea informativo, expresivo y llamativo. El título debe ser una oración completa que responda efectivamente a las preguntas de las 6w sin usar colones ni hipercapitalización. Debe ser directo y capturar la acción principal del contenido, presentando los hechos de manera clara y atractiva para el lector. Asegúrate de que el título refleje el tema central de manera precisa, evitando generalidades y siendo específico sobre quién está involucrado, qué está sucediendo, y dónde y por qué es relevante. Contenido: $content";
            case 'description':
                return "Basándote en el contenido proporcionado, que trata sobre eventos y actividades de La Iglesia de Jesucristo de los Santos de los Últimos Días, escribe una descripción en español que sea clara, concisa y atractiva para SEO. La descripción debe ser una única oración que responda a '¿Por qué debo leer esta noticia?', incluyendo un verbo de acción variado al inicio y no usando el verbo 'Descubre'. Limita la descripción a 160 caracteres para asegurar brevedad y directividad. Contenido: $content";
                break;
            case 'content':
                return <<<EOT
Soy un escritor de artículos de blog de noticias que escribe en código HTML y específicamente en español. Mi tarea es hacer curación de contenidos a partir de artículos existentes proporcionados en formato HTML, obtenidos mediante técnicas de scrapping. Ignoraré las imágenes y figuras del contenido original. No usaré el tag article. Comenzaré cada artículo con un primer párrafo sin título que sirve como introducción. Reescribiré estos artículos de manera extensa y detallada, utilizando encabezados de segundo nivel (h2) y tercer nivel (h3) para el resto del contenido, mejorando la legibilidad. Las citas textuales de lo que las personas hayan dicho son de especial importancia y serán enfatizadas en blockquotes, siguiendo el formato de ejemplo: "[blockquote con sus palabras textuales]". Los títulos serán informativos por sí mismos, eliminando el uso del colon para asegurar que expresen una sola idea coherente. Mantendré toda la información importante, incluyendo anécdotas, citas textuales, estadísticas, historias y momentos memorables en detalle, al tiempo que elimino elementos de publicidad, identificaciones de la fuente original y enlaces irrelevantes. El contenido final será presentado en un tono positivo, informativo, espiritual y alentador, en HTML correcto. Mi propósito es realizar una restructuración completa, no un resumen, asegurando que cada artículo sea interesante y atraiga a los lectores. Cada artículo concluirá con una lista de puntos destacados y una pregunta reflexiva. Contenido: $content
EOT;
                break;
        }
    }

    private function generateTitle(string $content): PromiseInterface
    {
        $prompt = $this->generatePrompt($content, 'title');
        return $this->callOpenAIAsync($prompt, 60)->then(
            function ($response) {
                $data = json_decode($response->getBody()->getContents(), true);
                $text = trim($data['choices'][0]['text']);
                // Procesa el texto si es necesario antes de devolverlo
                return str_replace(['"', "'"], '', rtrim($text, '.'));
            },
            function ($exception) {
                Log::error("Error al generar título: " . $exception->getMessage());
                return '';
            }
        );
    }

    private function generateDescription(string $content): PromiseInterface
    {
        $prompt = $this->generatePrompt($content, 'description');
        return $this->callOpenAIAsync($prompt, 160)->then(
            function ($response) {
                $data = json_decode($response->getBody()->getContents(), true);
                $text = trim($data['choices'][0]['text']);
                // Procesa el texto para ajustar a los requisitos de longitud y formato
                $textWithoutQuotes = str_replace(['"', "'"], '', $text);
                $finalText = rtrim($textWithoutQuotes, '.');
                if (strlen($finalText) > 160) {
                    $finalText = substr($finalText, 0, 157) . '...';
                }
                return $finalText;
            },
            function ($exception) {
                Log::error("Error al generar descripción: " . $exception->getMessage());
                return '';
            }
        );
    }

    private function saveTransformedNewsItem(array $transformedData, NewsItem $newsItem)
    {
        NewsPost::create([
            'title' => $transformedData['title'],
            'description' => $transformedData['description'],
            'slug' => $transformedData['slug'],
            'content' => $transformedData['content'],
            'link_original' => $newsItem->link,
            'pub_date' => $newsItem->pub_date,
            'source' => $newsItem->source,
            'country' => $newsItem->country,
            'language' => $newsItem->language,
            'featured_image' => $newsItem->featured_image,
            'author' => $newsItem->author,
        ]);
    }
}
