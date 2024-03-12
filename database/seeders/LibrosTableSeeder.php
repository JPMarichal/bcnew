<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Statement;

class LibrosTableSeeder extends Seeder
{
    public function run()
    {
        $path = storage_path('app/csv/escrituras/csv_libros.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $stmt = (new Statement())
            ->orderBy(function (array $a, array $b) {
                return $a['id'] <=> $b['id'];
            });

        $records = $stmt->process($csv);

        foreach ($records as $row) {
            DB::table('libros')->insert([
                'volumen_id' => $row['volumen_id'],
                'division_id' => $row['division_id'],
                'nombre' => $row['Nombre'],
                'abreviatura' => $row['Abreviatura'],
                'abreviatura_online' => $row['AbreviaturaOnline'],
                'num_capitulos' => $row['NumCapitulos'],
                'palabra_clave' => $row['PalabraClave'],
                'concepto_principal' => $row['ConceptoPrincipal'],
                'autor' => $row['Autor'],
                'autor_why' => $row['AutorWhy'],
                'f_redaccion' => $row['FRedaccion'],
                'fecha_redaccion_why' => $row['FechaRedaccionWhy'],
                'descripcion' => $row['Descripcion'],
                'introduccion' => $row['Introduccion'],
                'temas_estructura' => $row['TemasEstructura'],
                'sumario' => $row['Sumario'],
                'url' => $row['Url'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
