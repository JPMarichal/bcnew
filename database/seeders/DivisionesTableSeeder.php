<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Statement;

class DivisionesTableSeeder extends Seeder
{
    public function run()
    {
        $path = storage_path('app/csv/escrituras/csv_divisiones.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $stmt = (new Statement())
            ->orderBy(function (array $a, array $b) {
                return $a['IdDivision'] - $b['IdDivision'];
            });

        $records = $stmt->process($csv);

        foreach ($records as $row) {
            DB::table('divisiones')->insert([
                'volumen_id' => $row['IdVolumen'],
                'nombre' => $row['Nombre'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
