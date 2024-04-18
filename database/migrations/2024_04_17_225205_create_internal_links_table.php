<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalLinksTable extends Migration
{
    public function up()
    {
        Schema::create('internal_links', function (Blueprint $table) {
            $table->id();
            $table->string('texto');
            $table->unsignedBigInteger('linked_id');
            $table->string('object')->default('post');
            $table->foreign('linked_id')->references('id')->on('posts')->onDelete('cascade');
            $table->index(['texto', 'linked_id']);  // Índice para mejorar el rendimiento de las consultas
        });
    }

    public function down()
    {
        Schema::dropIfExists('internal_links');
    }
}
