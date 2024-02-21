<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorToNewsItemsTable extends Migration
{
    public function up()
    {
        Schema::table('news_items', function (Blueprint $table) {
            $table->string('author')->nullable();
        });
    }

    public function down()
    {
        Schema::table('news_items', function (Blueprint $table) {
            $table->dropColumn('author');
        });
    }
}
