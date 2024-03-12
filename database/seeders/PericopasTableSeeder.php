<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use League\Csv\Reader;
use League\Csv\Statement;

class PericopasTableSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        
        $path = storage_path('app/csv/escrituras/csv_pericopas.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $records = Statement::create()->process($csv);

        foreach ($records as $row) {
            DB::table('pericopas')->insert([
                'id' => $row['IdPericopa'],
                'capitulo_id' => $row['IdCapitulo'],
                'titulo' => $row['Titulo'],
                'versiculo_inicial' => $row['VersiculoInicial'],
                'versiculo_final' => $row['VersiculoFinal'],
                'descripcion' => $row['Descripcion'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        Schema::enableForeignKeyConstraints();
    }
}
