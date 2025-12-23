<?php

namespace Database\Seeders;

use App\Models\CatProcedimiento;
use App\Models\ConsultaMedica;
use App\Models\Especialidad;
use App\Models\FichaTurno;
use App\Models\HistorialMedico;
use App\Models\Medicamento;
use App\Models\RecetaTratamiento;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DemoDataSeeder extends Seeder
{
    /**
     * Seed datos operativos iniciales (turnos, consultas, historiales).
     */
    public function run(): void
    {
        $medico = User::whereHas('roles', fn($q) => $q->where('name', 'medico'))->first();
        $pacientes = User::whereHas('roles', fn($q) => $q->where('name', 'paciente'))->take(5)->get();

        if (! $medico || $pacientes->isEmpty()) {
            $this->command?->warn('No se encontraron médico o pacientes para poblar datos iniciales.');
            return;
        }

        // Especialidades base
        $especialidades = collect([
            ['nombre' => 'Medicina General'],
            ['nombre' => 'Cardiología'],
            ['nombre' => 'Pediatría'],
        ])->map(fn($data) => Especialidad::firstOrCreate($data));

        // Medicamentos base
        $meds = [
            ['nombre' => 'Amoxicilina', 'presentacion' => '500 mg cápsulas', 'activa' => true],
            ['nombre' => 'Paracetamol', 'presentacion' => '500 mg tabletas', 'activa' => true],
            ['nombre' => 'Ibuprofeno', 'presentacion' => '400 mg tabletas', 'activa' => true],
        ];
        foreach ($meds as $m) {
            Medicamento::firstOrCreate(['nombre' => $m['nombre']], Arr::except($m, ['nombre']));
        }

        // Procedimientos para asociar a consultas
        $procedIds = CatProcedimiento::inRandomOrder()->take(3)->pluck('id')->all();

        // Crear turnos, consultas e historiales vinculados
        $fechaBase = Carbon::now()->subDays(2);
        foreach ($pacientes as $idx => $paciente) {
            $especialidad = $especialidades[$idx % $especialidades->count()];

            $turno = FichaTurno::updateOrCreate(
                [
                    'paciente_id' => $paciente->id,
                    'emision' => $fechaBase->copy()->addHours($idx),
                ],
                [
                    'medico_id' => $medico->id,
                    'especialidad_id' => $especialidad->id,
                    'motivo' => 'Control de salud',
                    'estado' => $idx % 4 === 0 ? 'confirmado' : 'pendiente',
                    'observaciones' => 'Seguimiento ambulatorio.',
                    'created_at' => now(),
                ]
            );

            $consulta = ConsultaMedica::updateOrCreate(
                [
                    'paciente_id' => $paciente->id,
                    'fecha' => $fechaBase->copy()->addDays($idx)->toDateString(),
                ],
                [
                    'medico_id' => $medico->id,
                    'hora' => '09:00',
                    'motivo' => 'Consulta de seguimiento',
                    'diagnostico' => 'Evaluación clínica estable',
                    'tratamiento' => 'Medicación según indicación',
                    'indicaciones_paciente' => 'Tomar medicamentos y reposo moderado.',
                    'presion_arterial' => '120/80',
                    'temperatura' => 36.7,
                    'frecuencia_cardiaca' => 72,
                    'frecuencia_respiratoria' => 16,
                    'peso' => 70 + $idx,
                    'talla' => 1.70,
                    'imc' => round((70 + $idx) / (1.7 * 1.7), 2),
                    'evolucion' => 'Evolución sin novedades.',
                    'notas_adicionales' => 'Continuar controles periódicos.',
                ]
            );

            if ($procedIds) {
                $consulta->procedimientos()->sync($procedIds);
            }

            $medicamento = Medicamento::inRandomOrder()->first();
            if ($medicamento) {
                RecetaTratamiento::updateOrCreate(
                    [
                        'consulta_id' => $consulta->id,
                        'medicamento_id' => $medicamento->id,
                    ],
                    [
                        'dosis' => '1 tableta',
                        'frecuencia' => 'cada 8 horas',
                        'duracion' => '5 días',
                        'indicaciones' => 'Después de comidas',
                        'cantidad_recetada' => 15,
                        'cantidad_dispensada' => 0,
                        'created_at' => now(),
                    ]
                );
            }

            HistorialMedico::updateOrCreate(
                [
                    'paciente_id' => $paciente->id,
                    'fecha' => $fechaBase->copy()->addDays($idx)->toDateString(),
                ],
                [
                    'consulta_id' => $consulta->id,
                    'resumen' => 'Evaluación general del estado de salud',
                    'diagnostico' => 'Seguimiento clínico',
                    'tratamiento' => 'Plan de tratamiento indicado',
                    'antecedentes_personales' => 'Sin antecedentes relevantes',
                    'antecedentes_familiares' => 'Hipertensión en familia',
                    'habitos' => 'No fumador',
                    'medicamentos_actuales' => 'Ninguno',
                    'alergias' => 'Ninguna conocida',
                    'vacunas' => 'Esquema completo',
                    'examenes_fisicos' => 'Examen físico normal',
                    'notas_importantes' => 'Seguimiento en 1 mes',
                ]
            );
        }
    }
}
