<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use League\Csv\Reader;
use League\Csv\Statement;

class VersiculosTableSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $path = storage_path('app/csv/escrituras/csv_versiculos.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $records = Statement::create()->process($csv);

        foreach ($records as $row) {
            DB::table('versiculos')->insert([
                'id' => $row['IdVersiculo'],
                'capitulo_id' => $row['IdCapitulo'],
                'pericopa_id' => $row['IdPericopa'],
                'num_versiculo' => $row['NumVersiculo'],
                'contenido' => $row['Contenido'],
                'referencia' => $row['Referencia'],
                'imagen' => $row['Imagen'],
                'pie_imagen' => $row['PieImagen'],
                'video' => $row['Video'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
