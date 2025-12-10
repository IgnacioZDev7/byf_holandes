<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogosBasicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('cat_tipos_sangre')->truncate();
        DB::table('cat_nacionalidades')->truncate();
        DB::table('cat_estados_civiles')->truncate();
        DB::table('cat_generos')->truncate();
        DB::table('cat_parentescos')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('cat_tipos_sangre')->insert([
            ['codigo' => 'A+', 'descripcion' => 'A positivo'],
            ['codigo' => 'A-', 'descripcion' => 'A negativo'],
            ['codigo' => 'B+', 'descripcion' => 'B positivo'],
            ['codigo' => 'B-', 'descripcion' => 'B negativo'],
            ['codigo' => 'AB+', 'descripcion' => 'AB positivo'],
            ['codigo' => 'AB-', 'descripcion' => 'AB negativo'],
            ['codigo' => 'O+', 'descripcion' => 'O positivo'],
            ['codigo' => 'O-', 'descripcion' => 'O negativo'],
        ]);

        DB::table('cat_nacionalidades')->insert([
            ['nombre' => 'Bolivia', 'codigo_iso' => 'BO'],
            ['nombre' => 'Argentina', 'codigo_iso' => 'AR'],
            ['nombre' => 'Brasil', 'codigo_iso' => 'BR'],
            ['nombre' => 'Chile', 'codigo_iso' => 'CL'],
            ['nombre' => 'Perú', 'codigo_iso' => 'PE'],
            ['nombre' => 'Paraguay', 'codigo_iso' => 'PY'],
            ['nombre' => 'Colombia', 'codigo_iso' => 'CO'],
            ['nombre' => 'Ecuador', 'codigo_iso' => 'EC'],
            ['nombre' => 'Venezuela', 'codigo_iso' => 'VE'],
            ['nombre' => 'España', 'codigo_iso' => 'ES'],
        ]);

        DB::table('cat_estados_civiles')->insert([
            ['nombre' => 'Soltero/a'],
            ['nombre' => 'Casado/a'],
            ['nombre' => 'Divorciado/a'],
            ['nombre' => 'Viudo/a'],
            ['nombre' => 'Unión libre'],
            ['nombre' => 'Separado/a'],
        ]);

        DB::table('cat_generos')->insert([
            ['nombre' => 'Masculino'],
            ['nombre' => 'Femenino'],
        ]);

        DB::table('cat_parentescos')->insert([
            ['nombre' => 'Padre'],
            ['nombre' => 'Madre'],
            ['nombre' => 'Hermano/a'],
            ['nombre' => 'Esposo/a'],
            ['nombre' => 'Hijo/a'],
            ['nombre' => 'Abuelo/a'],
            ['nombre' => 'Tío/a'],
            ['nombre' => 'Primo/a'],
            ['nombre' => 'Amigo/a'],
            ['nombre' => 'Vecino/a'],
            ['nombre' => 'Otro'],
        ]);
    }
}
