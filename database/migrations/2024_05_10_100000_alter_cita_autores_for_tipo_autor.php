<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCitaAutoresForTipoAutor extends Migration
{
    public function up()
    {
        Schema::table('cita_autores', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_autor_id')->after('nombre');
          //  $table->dropColumn('url_imagen');  // Elimina el campo de imagen
            $table->foreign('tipo_autor_id')->references('id')->on('tipo_autores');
        });
    }

    public function down()
    {
        Schema::table('cita_autores', function (Blueprint $table) {
            $table->dropForeign(['tipo_autor_id']);
        //    $table->string('url_imagen')->nullable();  // Añade nuevamente el campo url_imagen en caso de rollback
            $table->dropColumn('tipo_autor_id');
        });
    }
}
