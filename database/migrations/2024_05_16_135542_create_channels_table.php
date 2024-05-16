<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('channel_id')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('language', 10)->default('es');
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('channels');
    }
}
