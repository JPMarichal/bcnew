<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersiculosTable extends Migration
{
    public function up()
    {
        Schema::create('versiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capitulo_id')->nullable()->constrained('capitulos')->onDelete('set null');
            $table->foreignId('pericopa_id')->nullable()->constrained('pericopas')->onDelete('set null');
            $table->integer('num_versiculo')->nullable();
            $table->text('contenido');
            $table->string('referencia', 50)->nullable();
            $table->string('imagen', 200)->nullable();
            $table->string('pie_imagen', 200)->nullable();
            $table->string('video', 150)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('versiculos');
    }
}
