<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersiculosComentariosTable extends Migration
{
    public function up()
    {
        Schema::create('versiculos_comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('versiculo_id')->constrained('versiculos')->onDelete('cascade');
            $table->string('titulo', 100)->nullable();
            $table->text('comentario')->nullable();
            $table->integer('orden')->nullable();
            $table->string('url_imagen', 200)->nullable();
            $table->string('url_video', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('versiculos_comentarios');
    }
}
