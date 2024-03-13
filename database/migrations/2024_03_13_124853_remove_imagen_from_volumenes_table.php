<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveImagenFromVolumenesTable extends Migration
{
    public function up()
    {
        Schema::table('volumenes', function (Blueprint $table) {
            $table->dropColumn('imagen');
        });
    }

    public function down()
    {
        Schema::table('volumenes', function (Blueprint $table) {
            $table->string('imagen', 150)->nullable()->after('nombre');
        });
    }
}
