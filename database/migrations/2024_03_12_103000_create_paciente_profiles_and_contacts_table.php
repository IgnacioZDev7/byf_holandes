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
        Schema::create('paciente_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('tipo_sangre_id')->nullable();
            $table->unsignedSmallInteger('nacionalidad_id')->nullable();
            $table->unsignedTinyInteger('estado_civil_id')->nullable();
            $table->unsignedTinyInteger('genero_id')->nullable();
            $table->text('alergias')->nullable();
            $table->text('enfermedades_cronicas')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('tipo_sangre_id')->references('id')->on('cat_tipos_sangre');
            $table->foreign('nacionalidad_id')->references('id')->on('cat_nacionalidades');
            $table->foreign('estado_civil_id')->references('id')->on('cat_estados_civiles');
            $table->foreign('genero_id')->references('id')->on('cat_generos');
        });

        Schema::create('direcciones', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('zona', 100)->nullable();
            $table->string('calle', 150)->nullable();
            $table->string('nro', 20)->nullable();
            $table->string('referencia', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nombre', 150);
            $table->string('telefono', 20);
            $table->unsignedTinyInteger('parentesco_id')->nullable();
            $table->timestamps();

            $table->foreign('parentesco_id')->references('id')->on('cat_parentescos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_contacts');
        Schema::dropIfExists('direcciones');
        Schema::dropIfExists('paciente_profiles');
    }
};
