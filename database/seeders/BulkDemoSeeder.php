<?php

namespace Database\Seeders;

use App\Models\CatGenero;
use App\Models\CatProcedimiento;
use App\Models\CatPruebaLaboratorio;
use App\Models\CatTipoSangre;
use App\Models\ConsultaMedica;
use App\Models\Direccion;
use App\Models\EmergencyContact;
use App\Models\Especialidad;
use App\Models\FichaTurno;
use App\Models\HistorialMedico;
use App\Models\Medicamento;
use App\Models\OrdenLaboratorio;
use App\Models\OrdenPrueba;
use App\Models\PacienteProfile;
use App\Models\RecetaTratamiento;
use App\Models\ResultadoLaboratorio;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

class BulkDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        // Roles
        $roleMedico = Role::firstOrCreate(['name' => 'medico', 'guard_name' => 'web']);
        $rolePaciente = Role::firstOrCreate(['name' => 'paciente', 'guard_name' => 'web']);

        // Catálogos necesarios
        $tipoSangreIds = CatTipoSangre::pluck('id')->all();
        $generoIds = CatGenero::pluck('id')->all();
        $procedIds = CatProcedimiento::pluck('id')->all();
        $pruebasLab = CatPruebaLaboratorio::pluck('id')->all();

        // Especialidades de apoyo
        $especialidades = Especialidad::all();
        if ($especialidades->count() < 3) {
            $nuevas = ['Medicina Interna', 'Dermatología', 'Neurología'];
            foreach ($nuevas as $nombre) {
                $especialidades->push(Especialidad::firstOrCreate(['nombre' => $nombre], ['activa' => true]));
            }
        }

        // Medicamentos de apoyo
        $baseMeds = [
            ['nombre' => 'Omeprazol', 'presentacion' => '20 mg cápsulas', 'activa' => true],
            ['nombre' => 'Losartan', 'presentacion' => '50 mg tabletas', 'activa' => true],
            ['nombre' => 'Metformina', 'presentacion' => '850 mg tabletas', 'activa' => true],
            ['nombre' => 'Salbutamol', 'presentacion' => 'Inhalador', 'activa' => true],
        ];
        foreach ($baseMeds as $m) {
            Medicamento::firstOrCreate(['nombre' => $m['nombre']], Arr::except($m, ['nombre']));
        }
        $medicamentos = Medicamento::all();

        // Crear médicos si hay pocos
        $medicos = User::whereHas('roles', fn($q) => $q->where('name', 'medico'))->get();
        $faltanMedicos = max(0, 5 - $medicos->count());
        for ($i = 0; $i < $faltanMedicos; $i++) {
            $user = User::create([
                'nombre' => $faker->firstName,
                'apellido_paterno' => $faker->lastName,
                'apellido_materno' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'ci' => $faker->unique()->numerify('########'),
                'telefono' => $faker->phoneNumber,
                'especialidad_id' => $especialidades->random()->id,
                'area_trabajo' => 'Consultorio',
            ]);
            $user->syncRoles([$roleMedico]);
            $medicos->push($user);
        }

        // Crear pacientes para llegar a 15
        $pacientes = User::whereHas('roles', fn($q) => $q->where('name', 'paciente'))->get();
        $faltanPacientes = max(0, 15 - $pacientes->count());
        for ($i = 0; $i < $faltanPacientes; $i++) {
            $user = User::create([
                'nombre' => $faker->firstName,
                'apellido_paterno' => $faker->lastName,
                'apellido_materno' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'ci' => $faker->unique()->numerify('########'),
                'telefono' => $faker->phoneNumber,
            ]);
            $user->syncRoles([$rolePaciente]);

            PacienteProfile::create([
                'user_id' => $user->id,
                'tipo_sangre_id' => Arr::random($tipoSangreIds),
                'nacionalidad_id' => 1,
                'estado_civil_id' => 1,
                'genero_id' => Arr::random($generoIds),
                'alergias' => $faker->randomElement(['Ninguna', 'Penicilina', 'Polen']),
                'enfermedades_cronicas' => $faker->randomElement(['Ninguna', 'Hipertensión', 'Diabetes']),
                'observaciones' => 'Paciente registrado para control',
            ]);

            Direccion::create([
                'user_id' => $user->id,
                'zona' => $faker->citySuffix,
                'calle' => $faker->streetName,
                'nro' => $faker->buildingNumber,
                'referencia' => $faker->secondaryAddress,
            ]);

            EmergencyContact::create([
                'user_id' => $user->id,
                'nombre' => $faker->name,
                'telefono' => $faker->phoneNumber,
                'parentesco_id' => 1,
            ]);

            $pacientes->push($user);
        }

        // Crear registros clínicos
        $pacientes = $pacientes->shuffle()->take(15);
        $especialidades = $especialidades->values();
        $medicos = $medicos->values();

        foreach ($pacientes as $idx => $paciente) {
            $medico = $medicos[$idx % $medicos->count()];
            $esp = $especialidades[$idx % $especialidades->count()];
            $fecha = Carbon::now()->subDays(rand(0, 10));

            $turno = FichaTurno::create([
                'paciente_id' => $paciente->id,
                'medico_id' => $medico->id,
                'especialidad_id' => $esp->id,
                'emision' => $fecha->copy()->addHours(9 + $idx % 5),
                'motivo' => 'Control de salud',
                'estado' => Arr::random(['pendiente', 'confirmado', 'atendido']),
                'observaciones' => 'Turno programado para evaluación',
                'created_at' => now(),
            ]);

            $consulta = ConsultaMedica::create([
                'medico_id' => $medico->id,
                'paciente_id' => $paciente->id,
                'fecha' => $fecha->toDateString(),
                'hora' => '09:00',
                'motivo' => 'Chequeo general',
                'diagnostico' => 'Evaluación clínica',
                'tratamiento' => 'Indicaciones según valoración',
                'indicaciones_paciente' => 'Reposo y buena hidratación',
                'presion_arterial' => '120/80',
                'temperatura' => 36.5,
                'frecuencia_cardiaca' => 72,
                'frecuencia_respiratoria' => 16,
                'peso' => 65 + $idx,
                'talla' => 1.70,
                'imc' => round((65 + $idx) / (1.7 * 1.7), 2),
                'evolucion' => 'Evolución favorable',
                'notas_adicionales' => 'Seguimiento programado',
            ]);

            if ($procedIds) {
                $consulta->procedimientos()->sync(Arr::random($procedIds, min(2, count($procedIds))));
            }

            $medicamento = $medicamentos->random();
            RecetaTratamiento::create([
                'consulta_id' => $consulta->id,
                'medicamento_id' => $medicamento->id,
                'dosis' => '1 dosis',
                'frecuencia' => 'cada 12 horas',
                'duracion' => '7 días',
                'indicaciones' => 'Tomar con agua',
                'cantidad_recetada' => 14,
                'cantidad_dispensada' => 0,
                'created_at' => now(),
            ]);

            HistorialMedico::create([
                'paciente_id' => $paciente->id,
                'fecha' => $fecha->toDateString(),
                'resumen' => 'Resumen clínico autogenerado',
                'diagnostico' => 'Diagnóstico autogenerado',
                'tratamiento' => 'Tratamiento autogenerado',
                'consulta_id' => $consulta->id,
                'antecedentes_personales' => 'Sin antecedentes relevantes',
                'antecedentes_familiares' => 'Hipertensión familiar',
                'habitos' => 'No fumador',
                'medicamentos_actuales' => 'Ninguno',
                'alergias' => 'Ninguna',
                'vacunas' => 'Completo',
                'examenes_fisicos' => 'Signos vitales normales',
                'notas_importantes' => 'Control en 1 mes',
            ]);

            // Órdenes y resultados de laboratorio
            if ($pruebasLab) {
                $orden = OrdenLaboratorio::create([
                    'consulta_id' => $consulta->id,
                    'medico_id' => $medico->id,
                    'paciente_id' => $paciente->id,
                    'fecha_solicitud' => $fecha->toDateString(),
                    'numero_registro' => 'LAB-' . str_pad($consulta->id, 6, '0', STR_PAD_LEFT),
                    'edad' => rand(20, 70),
                    'genero_id' => Arr::random($generoIds),
                    'diagnosis_principal' => 'Solicitud de rutina',
                    'urgencia' => 'Programada',
                    'observaciones_generales' => 'Orden de rutina',
                ]);

                $pruebaCatId = Arr::random($pruebasLab);
                $prueba = OrdenPrueba::create([
                    'orden_id' => $orden->id,
                    'cat_prueba_id' => $pruebaCatId,
                    'observaciones_especificas' => 'Sin observaciones',
                    'created_at' => now(),
                ]);

                ResultadoLaboratorio::create([
                    'prueba_id' => $prueba->id,
                    'resultado' => 'Resultado dentro de rangos normales',
                    'valor_referencia' => 'Ref. estándar',
                    'emision' => now(),
                    'created_at' => now(),
                ]);
            }
        }
    }
}
