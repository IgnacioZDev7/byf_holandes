<?php

namespace Database\Seeders;

use App\Models\CatGenero;
use App\Models\CatTipoSangre;
use App\Models\Direccion;
use App\Models\EmergencyContact;
use App\Models\PacienteProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class PacientesDemoSeeder extends Seeder
{
    /**
     * Seed pacientes de referencia con datos básicos asociados.
     */
    public function run(): void
    {
        $rolePaciente = Role::firstOrCreate(['name' => 'paciente', 'guard_name' => 'web']);

        $tiposSangre = CatTipoSangre::pluck('id', 'codigo');
        $generos = CatGenero::pluck('id', 'nombre');
        $parentescos = \DB::table('cat_parentescos')->pluck('id', 'nombre');

        $pacientes = [
            [
                'nombre' => 'Ignacio',
                'apellido_paterno' => 'Zarate',
                'apellido_materno' => 'Jamachi',
                'email' => 'paciente1@example.com',
                'telefono' => '70693511',
                'ci' => '7894561',
                'tipo_sangre' => 'A+',
                'genero' => 'Masculino',
                'direccion' => ['zona' => 'Centro', 'calle' => 'Av. Bolívar', 'nro' => '123'],
                'contacto' => ['nombre' => 'Luis Zarate', 'telefono' => '70693512', 'parentesco' => 'Hermano/a'],
            ],
            [
                'nombre' => 'Marco',
                'apellido_paterno' => 'Soto',
                'apellido_materno' => 'Guzmán',
                'email' => 'paciente2@example.com',
                'telefono' => '70693532',
                'ci' => '4587962',
                'tipo_sangre' => 'O+',
                'genero' => 'Masculino',
                'direccion' => ['zona' => 'Miraflores', 'calle' => 'Calle 5', 'nro' => '56'],
                'contacto' => ['nombre' => 'Ana Soto', 'telefono' => '70693533', 'parentesco' => 'Madre'],
            ],
            [
                'nombre' => 'María',
                'apellido_paterno' => 'Medina',
                'apellido_materno' => 'López',
                'email' => 'paciente3@example.com',
                'telefono' => '70693542',
                'ci' => '5689745',
                'tipo_sangre' => 'B+',
                'genero' => 'Femenino',
                'direccion' => ['zona' => 'Sopocachi', 'calle' => 'Calle Linares', 'nro' => '789'],
                'contacto' => ['nombre' => 'Carlos Medina', 'telefono' => '70693541', 'parentesco' => 'Padre'],
            ],
            [
                'nombre' => 'Josefa',
                'apellido_paterno' => 'Reyes',
                'apellido_materno' => 'Quispe',
                'email' => 'paciente4@example.com',
                'telefono' => '70693599',
                'ci' => '7894562',
                'tipo_sangre' => 'AB+',
                'genero' => 'Femenino',
                'direccion' => ['zona' => 'Villa Fátima', 'calle' => 'Av. 3', 'nro' => '12'],
                'contacto' => ['nombre' => 'Miguel Reyes', 'telefono' => '70693598', 'parentesco' => 'Esposo/a'],
            ],
            [
                'nombre' => 'Andrés',
                'apellido_paterno' => 'Campos',
                'apellido_materno' => 'Rojas',
                'email' => 'paciente5@example.com',
                'telefono' => '70693577',
                'ci' => '8745632',
                'tipo_sangre' => 'O-',
                'genero' => 'Masculino',
                'direccion' => ['zona' => 'Achumani', 'calle' => 'Calle 8', 'nro' => '22'],
                'contacto' => ['nombre' => 'Lucía Campos', 'telefono' => '70693578', 'parentesco' => 'Hermano/a'],
            ],
        ];

        foreach ($pacientes as $paciente) {
            $user = User::updateOrCreate(
                ['email' => $paciente['email']],
                [
                    'nombre' => $paciente['nombre'],
                    'apellido_paterno' => $paciente['apellido_paterno'],
                    'apellido_materno' => $paciente['apellido_materno'],
                    'ci' => $paciente['ci'] ?? null,
                    'telefono' => $paciente['telefono'] ?? null,
                    'password' => bcrypt('password'),
                ]
            );

            if (! $user->hasRole($rolePaciente)) {
                $user->syncRoles([$rolePaciente]);
            }

            PacienteProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'tipo_sangre_id' => $tiposSangre[$paciente['tipo_sangre']] ?? null,
                    'genero_id' => $generos[$paciente['genero']] ?? null,
                ]
            );

            if (! empty($paciente['direccion'])) {
                Direccion::updateOrCreate(
                    ['user_id' => $user->id],
                    $paciente['direccion']
                );
            }

            if (! empty($paciente['contacto'])) {
                EmergencyContact::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nombre' => $paciente['contacto']['nombre'] ?? null,
                        'telefono' => $paciente['contacto']['telefono'] ?? null,
                        'parentesco_id' => $parentescos[$paciente['contacto']['parentesco']] ?? null,
                    ]
                );
            }
        }
    }
}
