<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsHierarchicalToTaxonomiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('taxonomies', function (Blueprint $table) {
            $table->boolean('is_hierarchical')->default(false)->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taxonomies', function (Blueprint $table) {
            $table->dropColumn('is_hierarchical');
        });
    }
}
