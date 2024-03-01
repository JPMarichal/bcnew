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
            $description = $this->generateDescription($content);
            $newContent = $this->generateContent($content); // Genera contenido fake para pruebas

            // Si alguno de los campos generados está vacío, no insertar la noticia
            if (empty($title) || empty($description) || empty($newContent)) {
                Log::info("Omitida la inserción del registro debido a un campo vacío.", ['newsItem' => $newsItem->id]);
                continue;
            }

            $this->saveTransformedNewsItem([
                'title' => $title,
                'description' => $description,
                'slug' => Str::slug($title),
                'content' => $newContent,
            ], $newsItem);
        }
    }

    private function generateTitle(string $content): string
    {
        $prompt = "Basándote en el contenido proporcionado, que trata sobre eventos y actividades de La Iglesia de Jesucristo de los Santos de los Últimos Días, crea un título en español que sea informativo, expresivo y llamativo. El título debe ser una oración completa que responda efectivamente a las preguntas de las 6w sin usar colones ni hipercapitalización. Debe ser directo y capturar la acción principal del contenido, presentando los hechos de manera clara y atractiva para el lector. Asegúrate de que el título refleje el tema central de manera precisa, evitando generalidades y siendo específico sobre quién está involucrado, qué está sucediendo, y dónde y por qué es relevante. Contenido: $content";

        $title = $this->callOpenAI($prompt, 60);

        // Eliminar comillas simples y dobles, y punto al final si existe
        $titleWithoutQuotes = str_replace(['"', "'"], '', $title);
        $titleWithoutPeriod = rtrim($titleWithoutQuotes, '.');

        return $titleWithoutPeriod;
    }

    private function generateDescription(string $content): string
    {
        $prompt = "Basándote en el contenido proporcionado, que trata sobre eventos y actividades de La Iglesia de Jesucristo de los Santos de los Últimos Días, escribe una descripción en español que sea clara, concisa y atractiva para SEO. La descripción debe ser una única oración que responda a '¿Por qué debo leer esta noticia?', incluyendo un verbo de acción variado al inicio y no usando el verbo 'Descubre'. Limita la descripción a 160 caracteres para asegurar brevedad y directividad. Contenido: $content";

        $description = $this->callOpenAI($prompt, 160);

        // Eliminar comillas simples y dobles, y asegurar la longitud adecuada
        $descriptionWithoutQuotes = str_replace(['"', "'"], '', $description);
        $finalDescription = rtrim($descriptionWithoutQuotes, '.'); // Eliminar punto al final si existe

        // Ajustar la longitud a 120 caracteres, si es necesario
        if (strlen($finalDescription) > 160) {
            $finalDescription = substr($finalDescription, 0, 160) . '...';
        }

        $finalDescription = mb_convert_encoding($finalDescription, 'UTF-8', 'UTF-8');

        return $finalDescription;
    }

    private function generateContent(string $content): string
    {
        $safeContent = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

        $prompt = <<<EOT
Soy un escritor de artículos de blog de noticias que escribe en código HTML y específicamente en español. Mi tarea es hacer curación de contenidos a partir de artículos existentes proporcionados en formato HTML, obtenidos mediante técnicas de scrapping. Ignoraré las imágenes y figuras del contenido original. No usaré el tag article. Comenzaré cada artículo con un primer párrafo sin título que sirve como introducción. Reescribiré estos artículos de manera extensa y detallada, utilizando encabezados de segundo nivel (h2) y tercer nivel (h3) para el resto del contenido, mejorando la legibilidad. Las citas textuales de lo que las personas hayan dicho son de especial importancia y serán enfatizadas en blockquotes, siguiendo el formato de ejemplo: "Reflexionando en su conversión, el élder Kearon dijo: [blockquote con sus palabras textuales]". Los títulos serán informativos por sí mismos, eliminando el uso del colon para asegurar que expresen una sola idea coherente. Mantendré toda la información importante, incluyendo anécdotas, citas textuales, estadísticas, historias y momentos memorables en detalle, al tiempo que elimino elementos de publicidad, identificaciones de la fuente original y enlaces irrelevantes. El contenido final será presentado en un tono positivo, informativo, espiritual y alentador, en HTML correcto. Mi propósito es realizar una restructuración completa, no un resumen, asegurando que cada artículo sea interesante y atraiga a los lectores. Cada artículo concluirá con una lista de puntos destacados y una pregunta reflexiva. Contenido: $safeContent
EOT;

        $generatedContent = $this->callOpenAI($prompt, 2000); // Ajusta el max_tokens según la necesidad

        // El contenido generado ya estará listo para usar.
        return '<article id="news_content">'. $generatedContent . '</article>';
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
