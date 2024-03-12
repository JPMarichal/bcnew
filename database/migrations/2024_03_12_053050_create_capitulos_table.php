<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapitulosTable extends Migration
{
    public function up()
    {
        Schema::create('capitulos', function (Blueprint $table) {
            $table->id(); // Corregido para usar la convención de Laravel
            $table->foreignId('libro_id')->nullable()->constrained('libros')->onDelete('set null');
            $table->foreignId('parte_id')->nullable()->constrained('partes')->onDelete('set null');
            $table->integer('num_capitulo')->nullable();
            $table->string('capitulo', 100)->nullable();
            $table->string('abreviatura', 50)->nullable();
            $table->integer('num_versiculos')->nullable();
            $table->string('titulo_capitulo', 100)->nullable();
            $table->string('url_oficial', 150)->nullable();
            $table->string('url_audio', 150)->nullable();
            $table->integer('id_periodo')->nullable();
            $table->string('sumario', 500)->nullable();
            $table->text('resumen')->nullable();
            $table->string('ajuste_pericopas', 100)->nullable();
            $table->string('secuencia', 500)->nullable();
            $table->string('url_bc', 255)->nullable();
            $table->string('url_bcdev', 255)->nullable();
            $table->text('introduccion')->nullable();
            $table->text('conclusion')->nullable();
            $table->integer('estado_publicacion')->default(0)->comment('Estado con respecto al plan editorial. Valores posibles= 0 - Sin comenzar, 1 - En proceso, 2 - En revisión, 3 - Listo para impresión.');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('capitulos');
    }
}
