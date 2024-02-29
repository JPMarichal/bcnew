<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryToNewsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news_items', function (Blueprint $table) {
            // Agregar la columna 'country' como string y permitir que sea nullable
            $table->string('country')->nullable()->after('source');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news_items', function (Blueprint $table) {
            // Eliminar la columna 'country'
            $table->dropColumn('country');
        });
    }
}
