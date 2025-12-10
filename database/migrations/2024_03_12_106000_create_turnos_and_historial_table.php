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
        Schema::create('ficha_turno', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('paciente_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('emision');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('historial_medico', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('paciente_id')->constrained('users')->cascadeOnDelete();
            $table->date('fecha');
            $table->text('resumen');
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->unsignedInteger('consulta_id')->nullable();
            $table->timestamps();

            $table->foreign('consulta_id')
                ->references('id')
                ->on('consulta_medica')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_medico');
        Schema::dropIfExists('ficha_turno');
    }
};
