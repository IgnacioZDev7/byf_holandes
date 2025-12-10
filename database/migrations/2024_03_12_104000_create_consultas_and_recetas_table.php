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
        Schema::create('consulta_medica', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('medico_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('paciente_id')->constrained('users')->restrictOnDelete();
            $table->date('fecha');
            $table->time('hora')->nullable();
            $table->string('motivo', 255);
            $table->text('diagnostico')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('indicaciones_paciente')->nullable();
            $table->timestamps();
        });

        Schema::create('consulta_procedimientos', function (Blueprint $table) {
            $table->unsignedInteger('consulta_id');
            $table->unsignedInteger('procedimiento_id');
            $table->string('observaciones', 255)->nullable();
            $table->primary(['consulta_id', 'procedimiento_id']);

            $table->foreign('consulta_id')
                ->references('id')
                ->on('consulta_medica')
                ->cascadeOnDelete();
            $table->foreign('procedimiento_id')
                ->references('id')
                ->on('cat_procedimientos')
                ->restrictOnDelete();
        });

        Schema::create('medicamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 200);
            $table->string('presentacion', 100)->nullable();
            $table->boolean('activa')->default(true);
        });

        Schema::create('receta_tratamiento', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consulta_id');
            $table->unsignedInteger('medicamento_id');
            $table->string('dosis', 255);
            $table->string('frecuencia', 100);
            $table->string('duracion', 100)->nullable();
            $table->text('indicaciones')->nullable();
            $table->unsignedInteger('cantidad_recetada')->nullable();
            $table->unsignedInteger('cantidad_dispensada')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->foreign('consulta_id')
                ->references('id')
                ->on('consulta_medica')
                ->cascadeOnDelete();
            $table->foreign('medicamento_id')
                ->references('id')
                ->on('medicamentos')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receta_tratamiento');
        Schema::dropIfExists('medicamentos');
        Schema::dropIfExists('consulta_procedimientos');
        Schema::dropIfExists('consulta_medica');
    }
};
