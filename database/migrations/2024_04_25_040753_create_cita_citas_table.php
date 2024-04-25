<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitaCitasTable extends Migration
{
    public function up()
    {
        Schema::create('cita_citas', function (Blueprint $table) {
            $table->id();
            $table->text('texto')->unique();
            $table->string('titulo');
            $table->foreignId('autor_id')->constrained('cita_autores');
            $table->foreignId('fuente_id')->constrained('cita_fuentes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cita_citas');
    }
}
