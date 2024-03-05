<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScripturePlacesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scripture_places', function (Blueprint $table) {
            $table->id();
            $table->string('name_original', 150);
            $table->string('name', 150);
            $table->text('description_original');
            $table->string('description', 300);
            $table->longText('content_original');
            $table->string('volume', 50)->default('Biblia');
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scripture_places');
    }
}
