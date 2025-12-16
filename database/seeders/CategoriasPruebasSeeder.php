<?php

namespace Database\Seeders;

use App\Models\CatCategoriaPrueba;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriasPruebasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Grupo Sanguíneo y Factores RH'],
            ['nombre' => 'Hemograma Completo'],
            ['nombre' => 'Hemoglobina y Hematocrito'],
            ['nombre' => 'Tiempo de Coagulación y T. de sangría'],
            ['nombre' => 'Tiempo de Protrombina'],
            ['nombre' => 'Tiempo Parcial de Tromboplastina (TPTA)'],
            ['nombre' => 'Recuento de Plaquetas'],
            ['nombre' => 'Reactantes de Fase Aguda (VES)'],
            ['nombre' => 'Frotis de Sangre Periférica'],
            ['nombre' => 'Hemocultivo y Pruebas Compl.'],
            ['nombre' => 'Glicemia'],
            ['nombre' => 'Creatinina Sérica'],
            ['nombre' => 'Bilirrubinas Totales y Fracciones'],
            ['nombre' => 'Transaminasas TGO'],
            ['nombre' => 'Transaminasas TGP'],
            ['nombre' => 'Acido Úrico'],
            ['nombre' => 'Fosfatasa Alcalina'],
            ['nombre' => 'Amilasa Pancreática'],
            ['nombre' => 'Calcio Total'],
            ['nombre' => 'Electrolitos en Sangre (Na, K y Cl)'],
            ['nombre' => 'Gasometría Arterial o Venosa'],
            ['nombre' => 'Nitrógeno Ureico Sérico (NUS)'],
            ['nombre' => 'Urea'],
            // Segunda parte
            ['nombre' => 'Proteínas Totales y Fraccionadas'],
            ['nombre' => 'Lipasa'],
            ['nombre' => 'GGT'],
            ['nombre' => 'Albúmina'],
            ['nombre' => 'Proteinuria de 24 horas'],
            ['nombre' => 'Colesterol'],
            ['nombre' => 'HDL-LDL-VLDL'],
            ['nombre' => 'Triglicéridos'],
            ['nombre' => 'Hemoglobina Glucosilada'],
            ['nombre' => 'Prueba de Tolerancia a la Glucosa (5M)'],
            ['nombre' => 'RPR - VDRL para sífilis'],
            ['nombre' => 'Prueba Rápida para VIH/Sida'],
            ['nombre' => 'ASTO (Antiestreptolisina)'],
            ['nombre' => 'Factor Reumatoideo'],
            ['nombre' => 'Proteína C Reactiva (PCR)'],
            ['nombre' => 'Reacción Widal'],
            ['nombre' => 'Helicobacter Pylori'],
            ['nombre' => 'Examen General de Orina'],
            ['nombre' => 'Urocultivo'],
            ['nombre' => 'Coproparasitológico Simple'],
            ['nombre' => 'Coproparasitológico Seriado'],
            ['nombre' => 'Coprocultivo'],
            ['nombre' => 'Moco Fecal'],
            ['nombre' => 'Sangre Oculta en Heces'],
            // Tercera parte
            ['nombre' => 'Baciloscopía'],
            ['nombre' => 'Examen en Fresco'],
            ['nombre' => 'Cultivo para Gérmenes de:'],
            ['nombre' => 'Cultivo para Tuberculosis'],
            ['nombre' => 'Frotis Tinción GRAM'],
            ['nombre' => 'IgG/IgM anti SARS COV 2 (ELISA)'],
            ['nombre' => 'Prueba Rápida Antígeno del SARS COV 2'],
            ['nombre' => 'P.C.R. para SARS COV-2'],
            ['nombre' => 'P.C.R.'],
            ['nombre' => 'TORCH'],
            ['nombre' => 'PROCALCITONINA'],
            ['nombre' => 'TSH'],
            ['nombre' => 'T3'],
            ['nombre' => 'T4 libre'],
            ['nombre' => 'T4 total'],
            ['nombre' => 'PSA libre'],
            ['nombre' => 'PSA total'],
            ['nombre' => 'Prueba de Coombs directa - indirecta'],
            ['nombre' => 'Feminia'],
            ['nombre' => 'Transferrina'],
            ['nombre' => 'Tinción PAP'],
            ['nombre' => 'Citroquímico - Citológico'],
            ['nombre' => 'Acto Transfusional'],
        ];

        foreach ($categorias as $categoria) {
            CatCategoriaPrueba::firstOrCreate(
                ['nombre' => $categoria['nombre']]
            );
        }
    }
}
