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
            $table->index('pub_date', 'news_items_pub_date_index');
        });
    }

    public function down()
    {
        Schema::table('news_items', function (Blueprint $table) {
            $table->dropIndex('news_items_pub_date_index');
        });
    }

};
