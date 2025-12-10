<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cat_categorias_pruebas', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nombre', 100);
            $table->unique('nombre');
        });

        Schema::create('cat_pruebas_laboratorio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('categoria_id');
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->boolean('activa')->default(true);

            $table->foreign('categoria_id')
                ->references('id')
                ->on('cat_categorias_pruebas')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_pruebas_laboratorio');
        Schema::dropIfExists('cat_categorias_pruebas');
    }
};
