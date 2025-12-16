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
        Schema::table('consulta_medica', function (Blueprint $table) {
            $table->string('presion_arterial')->nullable();
            $table->decimal('temperatura', 4, 1)->nullable();
            $table->integer('frecuencia_cardiaca')->nullable();
            $table->integer('frecuencia_respiratoria')->nullable();
            $table->decimal('peso', 5, 2)->nullable();
            $table->decimal('talla', 4, 2)->nullable();
            $table->decimal('imc', 4, 2)->nullable();
            $table->text('evolucion')->nullable();
            $table->text('notas_adicionales')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consulta_medica', function (Blueprint $table) {
            $table->dropColumn([
                'presion_arterial',
                'temperatura',
                'frecuencia_cardiaca',
                'frecuencia_respiratoria',
                'peso',
                'talla',
                'imc',
                'evolucion',
                'notas_adicionales'
            ]);
        });
    }
};
