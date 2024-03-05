<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScripturePlace;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PopulateScripturePlaces extends Command
{
    protected $signature = 'populate:scripture-places';
    protected $description = 'Populates the scripture_places table from an HTML file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Iniciando el poblado de la tabla scripture_places...');

        // Truncar la tabla para evitar duplicados
        DB::table('scripture_places')->truncate();

        $path = database_path('data/Zondervan Atlas of the Bible 1.html');
        
        if (!File::exists($path)) {
            $this->error("El archivo $path no existe.");
            return;
        }

        $htmlContent = File::get($path);
        $crawler = new Crawler($htmlContent);

        $crawler->filter('p[lang="en-US"]')->each(function (Crawler $node) {
            $nameOriginal = trim($node->filter('span[style="font-weight:bold;"]')->first()->text());
            $descriptionOriginal = '';
            $contentOriginal = $node->html();

            if (strpos($contentOriginal, '&mdash;') !== false) {
                list(, $descriptionOriginal) = explode('&mdash;', $contentOriginal, 2);
                $descriptionOriginal = trim(strip_tags($descriptionOriginal)); // Eliminar etiquetas HTML
            }

            ScripturePlace::create([
                'name_original' => $nameOriginal,
                'description_original' => $descriptionOriginal,
                'content_original' => $contentOriginal,
            ]);
        });

        $this->info('La tabla scripture_places ha sido poblada exitosamente.');
    }
}
