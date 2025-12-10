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
        Schema::create('orden_laboratorio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consulta_id')->nullable();
            $table->foreignId('medico_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('paciente_id')->constrained('users')->restrictOnDelete();
            $table->date('fecha_solicitud');
            $table->string('numero_registro', 50)->nullable();
            $table->unsignedTinyInteger('edad')->nullable();
            $table->unsignedTinyInteger('genero_id')->nullable();
            $table->text('diagnosis_principal')->nullable();
            $table->enum('urgencia', ['Unidad/Servicio', 'Urgente', 'Programada'])->default('Unidad/Servicio');
            $table->text('observaciones_generales')->nullable();
            $table->timestamps();

            $table->foreign('consulta_id')
                ->references('id')
                ->on('consulta_medica')
                ->nullOnDelete();
            $table->foreign('genero_id')
                ->references('id')
                ->on('cat_generos');
        });

        Schema::create('prueba_laboratorio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('orden_id');
            $table->unsignedInteger('cat_prueba_id');
            $table->text('observaciones_especificas')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->foreign('orden_id')
                ->references('id')
                ->on('orden_laboratorio')
                ->cascadeOnDelete();
            $table->foreign('cat_prueba_id')
                ->references('id')
                ->on('cat_pruebas_laboratorio')
                ->restrictOnDelete();
        });

        Schema::create('resultado_laboratorio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('prueba_id');
            $table->text('resultado');
            $table->string('valor_referencia', 255)->nullable();
            $table->dateTime('emision');
            $table->timestamp('created_at')->nullable();

            $table->foreign('prueba_id')
                ->references('id')
                ->on('prueba_laboratorio')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultado_laboratorio');
        Schema::dropIfExists('prueba_laboratorio');
        Schema::dropIfExists('orden_laboratorio');
    }
};
