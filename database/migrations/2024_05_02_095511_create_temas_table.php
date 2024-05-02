<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemasTable extends Migration
{
    public function up()
    {
        Schema::create('temas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255)->unique();
            $table->foreignId('parent_id')->nullable()->constrained('temas')->onDelete('set null');
            $table->integer('orden')->default(1);
            $table->timestamps();

            $table->index(['parent_id'], 'idx_parent_id');
            $table->index(['titulo'], 'idx_titulo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('temas');
    }
}
