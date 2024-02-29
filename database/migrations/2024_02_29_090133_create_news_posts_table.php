<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsPostsTable extends Migration
{
    public function up()
    {
        Schema::create('news_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('link_original')->unique();
            $table->string('slug')->unique();
            $table->timestamp('pub_date')->useCurrent()->useCurrentOnUpdate();
            $table->string('source');
            $table->string('country')->nullable();
            $table->string('language', 2)->default('es');
            $table->string('featured_image')->nullable();
            $table->longText('content');
            $table->string('author')->nullable();
            $table->timestamps();

            // Indexación de campos para optimizar búsquedas y ordenaciones
            $table->index(['title', 'pub_date', 'source', 'country', 'language']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('news_posts');
    }
}
