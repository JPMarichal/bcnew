<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposTemasTable extends Migration
{
    public function up()
    {
        Schema::create('grupos_temas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->foreignId('tema_id')->constrained('temas')->onDelete('cascade');
            $table->integer('orden')->default(1);
            $table->timestamps();

            $table->index(['tema_id'], 'idx_tema_id');
            $table->index(['titulo'], 'idx_titulo_grupo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('grupos_temas');
    }
}
