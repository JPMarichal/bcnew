<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonomiesTable extends Migration
{
    public function up()
    {
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type','60')->index(); // Añadir indexación al campo 'type'
            $table->string('slug')->unique(); // 'slug' ya es único, lo que implica una indexación, pero es buena práctica asegurarse de que se entiende la intención
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taxonomies');
    }
}