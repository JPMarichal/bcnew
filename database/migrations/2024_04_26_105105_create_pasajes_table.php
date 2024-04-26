<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasajesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasajes', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->unique();
            $table->string('capitulo', 50);
            $table->integer('versiculo_inicial');
            $table->integer('versiculo_final');
            $table->timestamps();

            // Índices
            $table->index('titulo', 'idx_titulo');  // Índice por título
            $table->index(['capitulo', 'versiculo_inicial', 'versiculo_final'], 'idx_capitulo_versiculos');  // Índice compuesto por capítulo y versículos
            $table->index('capitulo', 'idx_capitulo');  // Índice por capítulo
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasajes');
    }
}
