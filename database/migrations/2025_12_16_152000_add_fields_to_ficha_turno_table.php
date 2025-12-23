<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ficha_turno', function (Blueprint $table) {
            if (! Schema::hasColumn('ficha_turno', 'medico_id')) {
                $table->unsignedBigInteger('medico_id')->nullable()->after('paciente_id');
                $table->foreign('medico_id')->references('id')->on('users')->nullOnDelete();
            }

            if (! Schema::hasColumn('ficha_turno', 'especialidad_id')) {
                $table->unsignedInteger('especialidad_id')->nullable()->after('medico_id');
                $table->foreign('especialidad_id')->references('id')->on('especialidades')->nullOnDelete();
            }

            if (! Schema::hasColumn('ficha_turno', 'motivo')) {
                $table->string('motivo', 255)->nullable()->after('emision');
            }

            if (! Schema::hasColumn('ficha_turno', 'estado')) {
                $table->string('estado', 20)->default('pendiente')->after('motivo');
            }

            if (! Schema::hasColumn('ficha_turno', 'observaciones')) {
                $table->text('observaciones')->nullable()->after('estado');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ficha_turno', function (Blueprint $table) {
            $table->dropForeign(['medico_id']);
            $table->dropForeign(['especialidad_id']);
            $table->dropColumn(['medico_id', 'especialidad_id', 'motivo', 'estado', 'observaciones']);
        });
    }
};
