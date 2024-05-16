<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropVideosTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('videos');
    }

    public function down()
    {
        // Aquí puedes opcionalmente agregar el código para recrear la tabla si necesitas revertir la migración.
    }
}
