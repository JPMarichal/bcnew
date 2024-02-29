<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTitleUniqueInNewsPostsTable extends Migration
{
    public function up()
    {
        Schema::table('news_posts', function (Blueprint $table) {
            // Primero, eliminar el índice existente para 'title'
            $table->dropIndex(['title']);

            // Luego, añadir la restricción de unicidad para 'title'
            $table->unique('title');
        });
    }

    public function down()
    {
        Schema::table('news_posts', function (Blueprint $table) {
            // Eliminar la restricción de unicidad
            $table->dropUnique(['title']);

            // Restaurar el índice original para 'title'
            $table->index('title');
        });
    }
}
