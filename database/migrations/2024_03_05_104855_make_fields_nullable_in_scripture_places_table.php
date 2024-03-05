<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFieldsNullableInScripturePlacesTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scripture_places', function (Blueprint $table) {
            // Hacer campos nullable excepto id, name_original y content_original
            $table->string('name', 150)->nullable()->change();
            $table->text('description_original')->nullable()->change();
            $table->string('description', 300)->nullable()->change();
            $table->string('volume', 50)->nullable()->default('Biblia')->change();
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scripture_places', function (Blueprint $table) {
            // Revertir cambios para hacer campos no nullable
            $table->string('name', 150)->nullable(false)->change();
            $table->text('description_original')->nullable(false)->change();
            $table->string('description', 300)->nullable(false)->change();
            $table->string('volume', 50)->nullable(false)->default('Biblia')->change();
        });
    }
}
