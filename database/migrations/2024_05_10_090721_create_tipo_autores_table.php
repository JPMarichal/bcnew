<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoAutoresTable extends Migration
{
    public function up()
    {
        Schema::create('tipo_autores', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 255);
            $table->tinyInteger('num_estrellas')->unsigned();
            $table->timestamps();
        });

        // Aquí puedes insertar los tipos iniciales
        DB::table('tipo_autores')->insert([
            ['descripcion' => 'Autoridad General', 'num_estrellas' => 5],
            ['descripcion' => 'Erudito de BYU', 'num_estrellas' => 4],
            ['descripcion' => 'Líder de la Iglesia', 'num_estrellas' => 4],
            ['descripcion' => 'Autor evangélico', 'num_estrellas' => 3],
            ['descripcion' => 'Autor de los primeros siglos', 'num_estrellas' => 3],
            ['descripcion' => 'Autor independiente', 'num_estrellas' => 2],
            ['descripcion' => 'Anónimo', 'num_estrellas' => 1],
            ['descripcion' => 'Autor desconocido', 'num_estrellas' => 1],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tipo_autores');
    }
}
