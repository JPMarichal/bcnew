<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTextoUniqueInInternalLinksTable extends Migration
{
    public function up()
    {
        Schema::table('internal_links', function (Blueprint $table) {
            // Asegurarse de que no hay duplicados antes de añadir el índice único
            // Puedes necesitar agregar lógica aquí para manejar posibles duplicados existentes
            $table->unique('texto', 'internal_links_texto_unique');
        });
    }

    public function down()
    {
        Schema::table('internal_links', function (Blueprint $table) {
            $table->dropUnique('internal_links_texto_unique');
        });
    }
}
