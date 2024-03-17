<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use App\Models\Escrituras\Capitulo;
use Illuminate\Support\Facades\DB;

class UpdateKeywordsCapitulo extends Command
{
    protected $signature = 'capitulo:updatekeywords';
    protected $description = 'Actualiza los campos title, description y keywords de la tabla capitulos basado en un archivo CSV.';

    public function handle()
    {
        $this->info('Iniciando la actualización de capítulos...');

        // Ruta al archivo CSV
        $csvPath = storage_path('app\csv\escrituras\title_desc_keywords.csv');

        // Abrir y leer el archivo CSV
        $csv = Reader::createFromPath($csvPath, 'r');
        $csv->setDelimiter(',');
        $csv->setHeaderOffset(null); // No hay encabezado

        // Leer todos los registros del CSV en memoria para reducir las consultas a la base de datos
        $records = $csv->getRecords();

        // Iniciar una transacción para mejorar el rendimiento
        DB::beginTransaction();

        try {
            foreach ($records as $record) {
                // Aplicar trim a los valores
                list($chapter, $title, $description, $keywords) = array_map('trim', $record);

                // Buscar y actualizar el modelo correspondiente
                Capitulo::where('referencia', $chapter)->update([
                    'title' => $title,
                    'description' => $description,
                    'keywords' => $keywords,
                ]);
            }

            DB::commit();
            $this->info('Los capítulos han sido actualizados exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();
            $this->error('Ocurrió un error durante la actualización: ' . $e->getMessage());
        }
    }
}
