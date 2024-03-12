<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Statement;

class CapitulosTableSeeder extends Seeder
{
    public function run()
    {
        $path = storage_path('app/csv/escrituras/csv_capitulos.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $stmt = (new Statement())
            ->orderBy(function(array $a, array $b) {
                return $a['IdCapitulo'] <=> $b['IdCapitulo'];
            });

        $records = $stmt->process($csv);

        foreach ($records as $row) {
            DB::table('capitulos')->insert([
                'libro_id' => $row['IdLibro'],
                'parte_id' => $row['IdParte'],
                'num_capitulo' => $row['NumCapitulo'],
                'capitulo' => $row['Capitulo'],
                'abreviatura' => $row['Abreviatura'],
                'num_versiculos' => $row['NumVersiculos'],
                'titulo_capitulo' => $row['TituloCapitulo'],
                'url_oficial' => $row['UrlOficial'],
                'url_audio' => $row['UrlAudio'],
                // Asegúrate de que 'id_periodo' sea un entero o NULL.
                'id_periodo' => $row['IdPeriodo'] === '' ? null : (int) $row['IdPeriodo'],
                'sumario' => $row['Sumario'],
                'resumen' => $row['Resumen'],
                'ajuste_pericopas' => $row['AjustePericopas'],
                'secuencia' => $row['Secuencia'],
                'url_bc' => $row['URLBC'],
                'url_bcdev' => $row['URLBCDEV'],
                'introduccion' => $row['Introduccion'],
                'conclusion' => $row['Conclusion'],
                'estado_publicacion' => $row['EstadoPublicacion'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
