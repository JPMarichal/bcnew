<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustIndexesOnNewsPostsTable extends Migration
{
    public function up()
    {
        Schema::table('news_posts', function (Blueprint $table) {
            // Eliminar el índice agrupado incorrecto
            $table->dropIndex('news_posts_title_pub_date_source_country_language_index');

            // Crear índices independientes para cada campo
            $table->index('title');
            $table->index('pub_date');
            $table->index('source');
            $table->index('country');
            $table->index('language');
        });
    }

    public function down()
    {
        Schema::table('news_posts', function (Blueprint $table) {
            // Eliminar los índices independientes
            $table->dropIndex(['title']);
            $table->dropIndex(['pub_date']);
            $table->dropIndex(['source']);
            $table->dropIndex(['country']);
            $table->dropIndex(['language']);

            // Restaurar el índice agrupado original en caso de rollback
            $table->index(['title', 'pub_date', 'source', 'country', 'language'], 'news_posts_title_pub_date_source_country_language_index');
        });
    }
}
