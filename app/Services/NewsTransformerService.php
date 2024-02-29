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
            $title = $this->generateTextWithOpenAI($content, 'titulo');
            $description = 'Fake description';
            $newContent = 'Fake content';
          //  $description = $this->generateTextWithOpenAI($content, 'descripcion');
          //  $newContent = $this->generateTextWithOpenAI($content, 'contenido');

            if ($title && $description && $newContent) {
                $slug = Str::slug($title);
                $this->saveTransformedNewsItem([
                    'title' => $title,
                    'description' => $description,
                    'slug' => $slug,
                    'content' => $newContent,
                ], $newsItem);
            } else {
                Log::info("La inserción del registro ha sido omitida debido a una falla en la generación de texto con OpenAI.", ['newsItem' => $newsItem->id]);
            }
        }
    }

    private function generateTextWithOpenAI(string $content, string $type): string
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ["role" => "user", "content" => "Genera un $type basado en: $content"]
                ],
                'temperature' => 0.7,
            ]);

            if ($response->successful() && !empty($response->json()['choices'][0]['message']['content'])) {
                return trim($response->json()['choices'][0]['message']['content']);
            } else {
                Log::error("Llamada a OpenAI fallida o sin contenido.", ['response' => $response->body()]);
                return '';
            }
        } catch (\Exception $e) {
            Log::error("Excepción capturada al llamar a OpenAI.", ['exception' => $e->getMessage()]);
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
