<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('news_items', function (Blueprint $table) {
            $table->string('language', 2)->after('source')->default('es'); // asumiendo que la mayoría de tus noticias son en español por defecto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('news_items', function (Blueprint $table) {
            $table->dropColumn('language');
        });
    }
};
