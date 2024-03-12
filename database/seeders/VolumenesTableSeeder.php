<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class VolumenesTableSeeder extends Seeder
{
    public function run()
    {
        $path = storage_path('app/csv/escrituras/csv_volumenes.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $results = collect($csv->getRecords()); // Utiliza la colección para facilitar la manipulación de datos

        $sorted = $results->sortBy('IdVolumen'); // Ordena los registros por 'IdVolumen'

        foreach ($sorted as $row) {
            DB::table('volumenes')->insert([
                'nombre' => $row['Nombre'],
                'imagen' => $row['Imagen'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
