<?php

namespace App\Services;

use App\Models\NewsItem;
use App\Models\NewsPost;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewsTransformerService
{
    private $openAiApiKey;

    public function __construct()
    {
        $this->openAiApiKey = env('OPENAI_API_KEY');
    }

    public function transformAndSaveNewsItems()
    {
        $newsItems = NewsItem::whereNotIn('link', NewsPost::pluck('link_original'))->get();

        foreach ($newsItems as $newsItem) {
            $content = $newsItem->content;
            $title = $this->generateTitle($content);

            if ($title) {
                $slug = Str::slug($title);
                $this->saveTransformedNewsItem([
                    'title' => $title,
                    'description' => 'Fake description', // Placeholder
                    'slug' => $slug,
                    'content' => 'Fake content', // Placeholder
                ], $newsItem);
            } else {
                Log::info("Omitida la inserción del registro debido a fallo en la generación del título.", ['newsItem' => $newsItem->id]);
            }
        }
    }

    private function generateTitle(string $content): string
    {
        $prompt = "Basándote en el contenido proporcionado, que trata sobre eventos y actividades de La Iglesia de Jesucristo de los Santos de los Últimos Días, crea un título en español que sea informativo, expresivo y llamativo. El título debe ser una oración completa que responda efectivamente a las preguntas de las 6w sin usar colones ni hipercapitalización. Debe ser directo y capturar la acción principal del contenido, presentando los hechos de manera clara y atractiva para el lector. Asegúrate de que el título refleje el tema central de manera precisa, evitando generalidades y siendo específico sobre quién está involucrado, qué está sucediendo, y dónde y por qué es relevante. Contenido: $content";

        $title = $this->callOpenAI($prompt, 60);

        // Ajustes finales para asegurar que el título sea más breve y no termine en punto
        $titleWithoutQuotes = str_replace(['"', "'"], '', $title); // Eliminar comillas
        $titleWithoutPeriod = rtrim($titleWithoutQuotes, '.'); // Eliminar punto al final si existe

        return $titleWithoutPeriod;
    }


    private function callOpenAI(string $prompt, int $maxTokens): string
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [["role" => "user", "content" => $prompt]],
                'temperature' => 0.7,
                'max_tokens' => $maxTokens,
            ]);

            if ($response->successful() && !empty($response->json()['choices'][0]['message']['content'])) {
                return trim($response->json()['choices'][0]['message']['content']);
            } else {
                Log::error("Falló la llamada a OpenAI o el contenido está vacío.", ['response' => $response->body()]);
                return '';
            }
        } catch (\Exception $e) {
            Log::error("Excepción al intentar generar texto con OpenAI.", ['exception' => $e->getMessage()]);
            return '';
        }
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
