<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volumen_id')->nullable()->constrained('volumenes')->onDelete('cascade');
            $table->foreignId('division_id')->nullable()->constrained('divisiones')->onDelete('cascade');
            $table->string('nombre', 30)->nullable();
            $table->string('abreviatura', 30)->nullable();
            $table->string('abreviatura_online', 30)->nullable();
            $table->integer('num_capitulos')->nullable();
            $table->string('palabra_clave', 100)->nullable();
            $table->string('concepto_principal', 150)->nullable();
            $table->string('autor', 100)->nullable();
            $table->text('autor_why')->nullable();
            $table->string('f_redaccion', 100)->nullable();
            $table->text('fecha_redaccion_why')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('introduccion')->nullable();
            $table->text('temas_estructura')->nullable();
            $table->string('sumario', 400)->nullable();
            $table->string('url', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('libros');
    }
}
