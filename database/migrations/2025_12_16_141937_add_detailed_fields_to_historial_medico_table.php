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
        Schema::table('historial_medico', function (Blueprint $table) {
            $table->text('antecedentes_personales')->nullable();
            $table->text('antecedentes_familiares')->nullable();
            $table->text('habitos')->nullable();
            $table->text('medicamentos_actuales')->nullable();
            $table->text('alergias')->nullable();
            $table->text('vacunas')->nullable();
            $table->text('examenes_fisicos')->nullable();
            $table->text('notas_importantes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial_medico', function (Blueprint $table) {
            $table->dropColumn([
                'antecedentes_personales',
                'antecedentes_familiares',
                'habitos',
                'medicamentos_actuales',
                'alergias',
                'vacunas',
                'examenes_fisicos',
                'notas_importantes'
            ]);
        });
    }
};
