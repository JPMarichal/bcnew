<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitaAutoresSeeder extends Seeder
{
    public function run()
    {
        DB::table('cita_autores')->insert([
            ['nombre' => 'Anónimo', 'url_imagen' => null, 'post_id' => null],
            ['nombre' => 'Autor desconocido', 'url_imagen' => null, 'post_id' => null]
        ]);
    }
}
