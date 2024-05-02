<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temas', function (Blueprint $table) {
            $table->id();
            $table->string('concepto', 255)->unique();
            $table->foreignId('parent_id')->nullable()->constrained('temas')->onDelete('set null');
            $table->foreignId('grupo_id')->nullable()->constrained('temas')->onDelete('set null');
            $table->integer('orden')->default(1);
            $table->string('tema_type', 50);
            $table->unsignedBigInteger('tema_id');
            $table->index(['tema_type', 'tema_id'], 'tema_polymorphic_index');
            $table->index(['grupo_id', 'orden'], 'idx_orden_grupo');
            $table->index('parent_id', 'idx_parent_id');
            $table->index('grupo_id', 'idx_grupo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temas');
    }
}
