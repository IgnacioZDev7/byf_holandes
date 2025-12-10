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
        Schema::create('cat_tipos_sangre', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('codigo', 5);
            $table->string('descripcion', 50);
        });

        Schema::create('cat_nacionalidades', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('nombre', 100);
            $table->char('codigo_iso', 2)->nullable();
        });

        Schema::create('cat_estados_civiles', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nombre', 50);
        });

        Schema::create('cat_generos', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nombre', 30);
        });

        Schema::create('cat_parentescos', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nombre', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_parentescos');
        Schema::dropIfExists('cat_generos');
        Schema::dropIfExists('cat_estados_civiles');
        Schema::dropIfExists('cat_nacionalidades');
        Schema::dropIfExists('cat_tipos_sangre');
    }
};
