<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use League\Csv\Reader;

class VersiculosComentariosTableSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $csv = Reader::createFromPath(storage_path('app/csv/escrituras/csv_comentariosversiculos.csv'), 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $record) {
            DB::table('versiculos_comentarios')->insert([
                'versiculo_id' => $record['IdVersiculo'],
                'titulo' => $record['Titulo'],
                'comentario' => $record['Comentario'],
                'orden' => $record['Orden'],
                'url_imagen' => $record['urlImagen'],
                'url_video' => $record['urlVideo'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
