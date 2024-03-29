<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\PasajeService;

class GenerarPasajesPng extends Command
{
    protected $signature = 'pasaje:generar-png {subdir : El nombre del subdirectorio bajo storage/app/images/pasajes}';
    protected $description = 'Genera imágenes PNG para los pasajes listados en el CSV y las guarda en un subdirectorio específico.';
    protected $pasajeService;

    public function __construct(PasajeService $pasajeService)
    {
        parent::__construct();
        $this->pasajeService = $pasajeService;
    }

    public function handle()
    {
        $subdir = $this->argument('subdir');
        $nombreSubdir = preg_replace('/[^A-Za-z0-9_\-]/', '_', $subdir);
        $pathSubdir = storage_path("app/images/pasajes/$nombreSubdir");

        if (!file_exists($pathSubdir)) {
            mkdir($pathSubdir, 0755, true);
            $this->info("Creado el subdirectorio: $pathSubdir");
        }

        $csvPath = storage_path('app/csv/pasajes/lstPasajes.csv');
        $records = array_map('str_getcsv', file($csvPath));

        foreach ($records as $record) {
            $referencia = $record[1];
            $titulo = $record[0];
            $this->info("Procesando: $referencia - $titulo");

            $nombreArchivo = str_replace(
                [':', ' ', '.','¿', '¡'],
                ['_', '_', '_', '', ''],
                $referencia
            ) . '.png';
            $rutaSalida = "$pathSubdir/$nombreArchivo";

            $rutaImagenTemp = $this->pasajeService->obtenerPasajeFormateado($referencia, 'png', $titulo);
            // Verifica que la ruta temporal exista y luego mueve el archivo al lugar final
            if (file_exists($rutaImagenTemp)) {
                rename($rutaImagenTemp, $rutaSalida);
                $this->info("Imagen guardada: $rutaSalida");
            } else {
                $this->error("No se pudo generar la imagen para $referencia");
            }
        }
    }
}
