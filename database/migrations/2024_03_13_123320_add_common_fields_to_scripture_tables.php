<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $tables = ['volumenes', 'divisiones', 'libros', 'partes', 'capitulos', 'pericopas'];

    public function up()
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('title')->nullable()->after('id');
                $table->text('description')->nullable()->after('title');
                $table->string('featured_image')->nullable()->after('description');
                $table->text('keywords')->nullable()->after('featured_image');
            });
        }
    }

    public function down()
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn(['title', 'description', 'featured_image', 'keywords']);
            });
        }
    }
};
