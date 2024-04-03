<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostMetaTable extends Migration
{
    public function up()
    {
        Schema::create('post_meta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('meta_key');
            $table->text('meta_value')->nullable();
            $table->timestamps();

            // Crear un índice para mejorar las consultas por clave de metadato
            $table->index(['post_id', 'meta_key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_meta');
    }
}
