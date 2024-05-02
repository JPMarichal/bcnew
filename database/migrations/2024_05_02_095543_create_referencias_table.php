<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferenciasTable extends Migration
{
    public function up()
    {
        Schema::create('referencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('concepto_id')->constrained('conceptos')->onDelete('cascade');
            $table->string('origen', 50);
            $table->text('referencia');
            $table->timestamps();

            $table->index(['concepto_id'], 'idx_concepto_id');
            $table->index(['origen'], 'idx_origen');
            $table->index(['referencia'], 'idx_referencia');
        });
    }

    public function down()
    {
        Schema::dropIfExists('referencias');
    }
}
