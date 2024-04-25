<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitaFuentesTable extends Migration
{
    public function up()
    {
        Schema::create('cita_fuentes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo_publicacion', ['libro', 'articulo', 'discurso']);
            $table->string('fecha_publicacion')->nullable();
            $table->string('isbn')->nullable();
            $table->string('url')->nullable();
            $table->string('nombre_revista')->nullable();
            $table->integer('numero_pagina')->nullable();
            $table->string('ocasion')->nullable();
            $table->timestamps();
            $table->unique(['titulo', 'tipo_publicacion', 'fecha_publicacion'], 'unique_source');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cita_fuentes');
    }
}
