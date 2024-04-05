<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        // Asume que el archivo CSV está ubicado en database/seeders/csv/wp_posts.csv
        $csv = Reader::createFromPath(database_path('seeders/csv/csv_wp_posts.csv'), 'r');
        $csv->setHeaderOffset(0); // Establece que la primera fila es la cabecera

        // Limpiar la tabla posts antes de la importación
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('posts')->truncate();
        DB::table('post_meta')->truncate(); // Asegúrate de truncar también las tablas relacionadas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($csv->getRecords() as $record) {
            // Transforma los valores necesarios, especialmente las fechas y posiblemente el 'status'
            $status = $record['post_status'] === 'publish' ? 'published' : $record['post_status'];

            Post::create([
                'id' => $record['ID'],
                'title' => $record['post_title'],
                'slug' => $record['post_name'], // 'post_name' es el slug en WP
                'content' => $record['post_content'],
                'excerpt' => $record['post_excerpt'] ?? null,
                'author_id' => 1, // $record['post_author'], // Asegúrate de mapear correctamente los autores de WP a usuarios en Laravel
                'status' => $status, // Usa 'draft' como valor predeterminado
                'publish_date' => $record['post_date'] ?? null, // 'post_date' en WP
                'post_modified' => $record['post_modified'] ?? now(),
                // 'post_parent' => $record['post_parent'] ?? null,
                'post_type' => $record['post_type'] ?? 'post',
                'post_date' => $record['post_date'] ?? now(),
            ]);
        }
    }
}
