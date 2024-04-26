<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPasajesTableForCapitulos extends Migration
{
    public function up()
    {
        Schema::table('pasajes', function (Blueprint $table) {
            // Eliminar índices antiguos relacionados con 'capitulo'
            $table->dropIndex('idx_capitulo_versiculos');
            $table->dropIndex('idx_capitulo');

            // Eliminar columna antigua
            $table->dropColumn('capitulo');

            // Agregar la nueva columna con la clave foránea
            $table->unsignedBigInteger('capitulo_id')->after('titulo');
            $table->foreign('capitulo_id')->references('id')->on('capitulos')->onDelete('cascade');

            // Agregar nuevamente índices necesarios con el nuevo campo
            $table->index(['capitulo_id', 'versiculo_inicial', 'versiculo_final'], 'idx_capitulo_id_versiculos');
            $table->index('capitulo_id', 'idx_capitulo_id');
        });
    }

    public function down()
    {
        Schema::table('pasajes', function (Blueprint $table) {
            $table->dropForeign(['capitulo_id']);
            $table->dropIndex('idx_capitulo_id_versiculos');
            $table->dropIndex('idx_capitulo_id');
            $table->dropColumn('capitulo_id');

            // Restaurar la columna y índices originales
            $table->string('capitulo', 50);
            $table->index(['capitulo', 'versiculo_inicial', 'versiculo_final'], 'idx_capitulo_versiculos');
            $table->index('capitulo', 'idx_capitulo');
        });
    }
}
