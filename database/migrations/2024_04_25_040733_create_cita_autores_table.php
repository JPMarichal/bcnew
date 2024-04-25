<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitaAutoresTable extends Migration
{
    public function up()
    {
        Schema::create('cita_autores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('url_imagen')->nullable()->unique();
            $table->foreignId('post_id')->nullable()->constrained('posts')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cita_autores');
    }
}
