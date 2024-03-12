<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolumenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volumenes', function (Blueprint $table) {
            $table->id(); // Laravel automáticamente creará una columna 'id' autoincremental.
            $table->string('nombre', 100)->nullable();
            $table->string('imagen', 150)->nullable();
            $table->timestamps(); // Laravel automáticamente añadirá las columnas 'created_at' y 'updated_at'.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volumenes');
    }
}
