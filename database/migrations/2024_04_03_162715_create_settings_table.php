<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->boolean('autoload')->default(false);
            $table->timestamps();

            // Índices
            $table->index(['key', 'autoload']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
