<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConceptosTable extends Migration
{
    public function up()
    {
        Schema::create('conceptos', function (Blueprint $table) {
            $table->id();
            $table->text('concepto');
            $table->foreignId('grupo_id')->constrained('grupos_temas')->onDelete('cascade');
            $table->integer('orden')->default(1);
            $table->timestamps();

            $table->index(['grupo_id'], 'idx_grupo_id');
            $table->index(['concepto'], 'idx_concepto');
        });
    }

    public function down()
    {
        Schema::dropIfExists('conceptos');
    }
}
