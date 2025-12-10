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
        Schema::create('cat_procedimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo', 12);
            $table->string('nombre', 255);
            $table->enum('area', ['Consulta Externa', 'Emergencia', 'Hospitalizacion', 'Otros'])->default('Consulta Externa');
            $table->boolean('activa')->default(true);
            $table->unique('codigo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_procedimientos');
    }
};
