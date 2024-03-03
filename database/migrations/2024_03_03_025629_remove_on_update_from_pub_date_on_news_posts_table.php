<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RemoveOnUpdateFromPubDateOnNewsPostsTable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE news_posts MODIFY COLUMN pub_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    public function down()
    {
        DB::statement('ALTER TABLE news_posts MODIFY COLUMN pub_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }
}
