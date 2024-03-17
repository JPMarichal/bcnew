<?php

namespace App\Console\Commands;

require 'vendor/autoload.php';
use Illuminate\Console\Command;
use Intervention\Image\ImageManager;
use App\Models\Escrituras\Capitulo;


class GenerateChapterImages extends Command
{
    protected $signature = 'generate:chapter-images';
    protected $description = 'Genera imágenes para los capítulos con el nombre superpuesto.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $capitulos = Capitulo::inRandomOrder()->take(10)->get();

        $manager = new ImageManager('gd');


        $this->info('Imágenes generadas exitosamente.');
    }
}
