<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPostsTable extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Agregar los nuevos campos
            $table->timestamp('post_modified')->nullable();
            $table->unsignedBigInteger('post_parent')->nullable();
            $table->string('post_type')->default('post');
            $table->dateTime('post_date')->nullable();
            
            // Agregar índice para post_parent y post_type
            $table->index(['post_parent', 'post_type']);
            
            // Agregar la relación para post_parent. Asegúrate de que esta línea sea adecuada para tu estructura y requisitos.
            $table->foreign('post_parent')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['post_parent']);
            $table->dropIndex(['post_parent', 'post_type']);
            $table->dropColumn('post_modified');
            $table->dropColumn('post_parent');
            $table->dropColumn('post_type');
            $table->dropColumn('post_date');
        });
    }
}
