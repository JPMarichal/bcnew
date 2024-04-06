<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;

class PostMetaTableSeeder extends Seeder
{
    public function run()
    {
        // Asume que el archivo CSV está ubicado en database/seeders/csv/csv_wp_postmeta.csv
        $csv = Reader::createFromPath(database_path('seeders/csv/csv_wp_postmeta.csv'), 'r');
        $csv->setHeaderOffset(0); // Establece que la primera fila es la cabecera

        // Limpiar la tabla post_meta antes de la importación
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('post_meta')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($csv->getRecords() as $record) {
            DB::table('post_meta')->insert([
                'id' => $record['meta_id'],
                'post_id' => $record['post_id'],
                'meta_key' => $record['meta_key'],
                'meta_value' => $record['meta_value'],
                'created_at' => now(), // Asumiendo que quieres marcar la fecha de creación al momento de la importación
                'updated_at' => now(), // Asumiendo que quieres marcar la fecha de actualización al momento de la importación
            ]);
        }
    }
}
