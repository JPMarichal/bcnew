<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxonomableTable extends Migration
{
    public function up()
    {
        Schema::create('taxonomable', function (Blueprint $table) {
            $table->foreignId('taxonomy_term_id')->constrained('taxonomy_terms')->onDelete('cascade');
            $table->morphs('taxonomable');
            $table->timestamps();

            $table->unique(['taxonomy_term_id', 'taxonomable_id', 'taxonomable_type'], 'taxonomable_index');
        });
    }

    public function down()
    {
        Schema::dropIfExists('taxonomable');
    }
}
