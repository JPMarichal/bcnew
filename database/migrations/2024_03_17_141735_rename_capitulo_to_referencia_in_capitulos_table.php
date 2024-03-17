<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCapituloToReferenciaInCapitulosTable extends Migration
{
    /**
     * Ejecuta las migraciones de la base de datos.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('capitulos', function (Blueprint $table) {
            // Renombrar la columna capitulo a referencia
            $table->renameColumn('capitulo', 'referencia');
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('capitulos', function (Blueprint $table) {
            // Revertir el cambio si es necesario
            $table->renameColumn('referencia', 'capitulo');
        });
    }
}
