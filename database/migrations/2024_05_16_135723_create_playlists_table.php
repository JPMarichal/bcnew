<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaylistsTable extends Migration
{
    public function up()
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('channel_id')->constrained('channels')->onDelete('cascade');
            $table->string('playlist_id')->unique();
            $table->string('title');
            $table->string('etag')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('playlists');
    }
}
