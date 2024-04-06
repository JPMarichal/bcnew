<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class UpdateAttachmentsSlugsSeeder extends Seeder
{
    public function run()
    {
        // Asume que el archivo CSV se llama 'wordpress-all-attachments.csv' y se encuentra en 'database/seeders/csv'
        $csv = Reader::createFromPath(database_path('seeders/csv/wordpress-all-attachments.csv'), 'r');
        $csv->setHeaderOffset(0); // La primera fila del CSV son los encabezados

        $records = $csv->getRecords(['post_id', 'attachment_id', 'attachment_url', 'is_featured_image']);

        foreach ($records as $record) {
            // Actualizar el slug de cada attachment usando 'attachment_url' del CSV.
            DB::table('posts')
                ->where('id', $record['attachment_id'])
                ->update(['slug' => $record['attachment_url']]);

            // Aquí no necesitas una lógica adicional para manejar la imagen destacada,
            // ya que estás actualizando directamente el slug basado en el 'attachment_id'.
        }
    }
}
