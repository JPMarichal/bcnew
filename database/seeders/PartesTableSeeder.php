<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use League\Csv\Reader;
use League\Csv\Statement;

class PartesTableSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $path = storage_path('app/csv/escrituras/csv_partes.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $stmt = (new Statement())
            ->orderBy(function(array $a, array $b) {
                return $a['id'] <=> $b['id'];
            });

        $records = $stmt->process($csv);

        foreach ($records as $row) {
            DB::table('partes')->insert([
                'id' => $row['id'],
                'libro_id' => $row['libro_id'],
                'nombre' => $row['Nombre'],
                'sumario' => $row['Sumario'],
                'descripcion' => $row['Descripcion'],
                'orden' => $row['Orden'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
