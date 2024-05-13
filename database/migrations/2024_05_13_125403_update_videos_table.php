<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            // Primero, eliminar el índice que involucra la columna 'platform'
            $table->dropUnique('idx_platform_video_id');

            // Ahora es seguro eliminar las columnas
            $table->dropColumn('platform');
            $table->dropColumn('likes_count');
            $table->dropColumn('comments_count');
            $table->dropColumn('shares_count');

            // Añadir nuevos campos
            $table->string('channel_id')->after('video_url');
            $table->string('channel_title')->after('channel_id');
            $table->string('playlist_id')->nullable()->after('channel_title');
            $table->string('playlist_title')->nullable()->after('playlist_id');
            $table->string('language', 10)->default('es')->after('playlist_title');
            $table->unsignedBigInteger('post_id')->nullable()->after('language');
            $table->string('etag')->nullable()->after('post_id');

            // Crear índices para los nuevos campos
            $table->index('channel_id', 'idx_channel_id');
            $table->index('playlist_id', 'idx_playlist_id');
            $table->index('user_id', 'idx_user_id');
            $table->index('post_id', 'idx_post_id');

            // Crear índices de texto completo para búsquedas
            $table->fullText(['title', 'description', 'channel_title', 'playlist_title', 'user_name'], 'idx_fulltext_search');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            // Agregar nuevamente los campos eliminados y el índice original
            $table->enum('platform', ['youtube', 'tiktok'])->default('youtube');
            $table->unsignedBigInteger('likes_count')->default(0);
            $table->unsignedBigInteger('comments_count')->default(0);
            $table->unsignedBigInteger('shares_count')->default(0);
            $table->addUnique(['platform', 'video_id'], 'idx_platform_video_id');
            
            // Eliminar los nuevos campos y los nuevos índices
            $table->dropColumn(['channel_id', 'channel_title', 'playlist_id', 'playlist_title', 'language', 'post_id', 'etag']);
            $table->dropIndex(['idx_channel_id', 'idx_playlist_id', 'idx_user_id', 'idx_post_id']);
            $table->dropIndex('idx_fulltext_search');
        });
    }
};
