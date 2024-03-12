<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePericopasTable extends Migration
{
    public function up()
    {
        Schema::create('pericopas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capitulo_id')->constrained()->onDelete('cascade');
            $table->string('titulo', 100)->nullable();
            $table->integer('versiculo_inicial')->nullable();
            $table->integer('versiculo_final')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pericopas');
    }
}
