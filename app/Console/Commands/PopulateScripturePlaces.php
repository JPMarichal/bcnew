<?php

namespace App\Console\Commands;

use App\Models\ScripturePlace;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class PopulateScripturePlaces extends Command
{
    protected $signature = 'populate:scripture-places';
    protected $description = 'Populates the scripture_places table from an HTML file';
    private $openAiApiKey;

    public function __construct()
    {
        parent::__construct();
        $this->openAiApiKey = env('OPENAI_API_KEY');
    }

    public function handle()
    {
        $this->info('Iniciando el poblado de la tabla scripture_places...');

        $path = database_path('data/Zondervan Atlas of the Bible 1.html');

        if (!File::exists($path)) {
            $this->error("El archivo $path no existe.");
            return;
        }

        $htmlContent = File::get($path);
        $crawler = new Crawler($htmlContent);

        // Obtener todos los nombres ya traducidos en la tabla
        $translatedNames = ScripturePlace::pluck('name_original')->toArray();

        $crawler->filter('p[lang="en-US"]')->each(function (Crawler $node) use ($translatedNames) {
            $nameOriginal = trim($node->filter('span[style="font-weight:bold;"]')->first()->text());

            // Si el nombre ya está traducido, continuamos con el siguiente registro
            if (in_array($nameOriginal, $translatedNames)) {
                return;
            }

            $descriptionOriginal = '';
            $contentOriginal = $node->html();

            if (strpos($contentOriginal, '&mdash;') !== false) {
                list(, $descriptionOriginal) = explode('&mdash;', $contentOriginal, 2);
                $descriptionOriginal = trim(strip_tags($descriptionOriginal)); // Eliminar etiquetas HTML
            }

            // Aquí se añade la lógica para traducir name_original a español antes de crear el registro
            $nameTranslated = $this->translateName($nameOriginal);

            ScripturePlace::create([
                'name_original' => $nameOriginal,
                'name' => $nameTranslated, // Usar el nombre traducido
                'description_original' => $descriptionOriginal,
                'content_original' => $contentOriginal,
            ]);
        });

        $this->info('La tabla scripture_places ha sido poblada exitosamente.');
    }



    private function translateName($nameOriginal)
    {
        $prompt = "Traduce el nombre de lugar bíblico '{$nameOriginal}' del inglés al español, y devuelve solamente su nombre traducido, exactamente como ha sido traducido en la Biblia Reina Valera 1960. Si hay variantes, devuelve sólo un término, la mejor alternativa. No hagas interpretaciones de los términos. Por ejemplo, 'Jerusalem' se traducirá como 'Jerusalén'. Procurar que los nombres sean únicos y proporcionar solo la traducción del nombre del lugar, sin texto adicional ni puntos al final.";
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo', // Usa el modelo especificado en el servicio NewsTransformerService
                'messages' => [["role" => "user", "content" => $prompt]],
                'max_tokens' => 60,
                'temperature' => 0.7,
            ]);

            //  if ($response->successful() && !empty($response->json()['choices'][0]['text'])) {
            $nameTranslated = trim($response->json()['choices'][0]['message']['content']);
            $this->info($nameOriginal . '->' . $nameTranslated);
            return $nameTranslated;
            /*   } else {
                $this->error($response->json());
                die();
                // return $nameOriginal; // Devuelve el original si la traducción falla
            } */
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            die();
            // return $nameOriginal; // Devuelve el original si ocurre una excepción
        }
    }
}
