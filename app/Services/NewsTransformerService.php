<?php

namespace App\Services;

use App\Models\NewsItem;
use App\Models\NewsPost;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class NewsTransformerService
{
    private $openAiApiKey;
    private $baseContent;

    public function __construct()
    {
        $this->openAiApiKey = env('OPENAI_API_KEY');
    }

    public function transformAndSaveNewsItems()
    {
        $newsItems = NewsItem::whereNotIn('link', NewsPost::pluck('link_original'))->get();

        foreach ($newsItems as $newsItem) {
            // Almacenar el contenido base para ser utilizado en la generación de título, descripción y contenido
            $this->baseContent = $newsItem->content;

            $title = $this->generateTitle();
            $description = $this->generateDescription();
            $content = $this->generateContent();
            $slug = $this->generateSlug($title);

            $this->saveTransformedNewsItem([
                'title' => $title,
                'description' => $description,
                'slug' => $slug,
                'content' => $content,
            ], $newsItem);
        }
    }

    private function generateTitle(): string
    {
        return $this->generateTextWithOpenAI("Summarize this content into a compelling title, in Spanish: {$this->baseContent}", 60);
    }

    private function generateDescription(): string
    {
        return $this->generateTextWithOpenAI("Write a brief description based on the following content, in Spanish: {$this->baseContent}", 100);
    }

    private function generateContent(): string
    {
        // Puedes ajustar este prompt para refinar cómo quieres que sea generado el contenido basado en el original
        return $this->generateTextWithOpenAI("Rewrite the content in a more engaging and informative way, in Spanish and HTML: {$this->baseContent}", 300);
    }

    private function generateTextWithOpenAI(string $prompt, int $maxTokens): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->openAiApiKey
        ])->post('https://api.openai.com/v4/completions', [
            'model' => 'text-davinci-003', // Asegúrate de ajustar este modelo según tus necesidades
            'prompt' => $prompt,
            'temperature' => 0.7,
            'max_tokens' => $maxTokens,
        ]);

        return $response->json()['choices'][0]['text'] ?? 'Default text';
    }

    private function generateSlug(string $title): string
    {
        return Str::slug($title); // Asegúrate de usar Str::slug para versiones recientes de Laravel
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
