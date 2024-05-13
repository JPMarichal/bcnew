<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', ['youtube', 'tiktok'])->default('youtube');
            $table->string('video_id');
            $table->string('video_url');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_id')->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->unsignedBigInteger('likes_count')->default(0);
            $table->unsignedBigInteger('comments_count')->default(0);
            $table->unsignedBigInteger('shares_count')->default(0);
            $table->text('hashtags')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->unsignedInteger('video_duration')->nullable();
            $table->timestamps();

            $table->unique(['platform', 'video_id'], 'idx_platform_video_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
