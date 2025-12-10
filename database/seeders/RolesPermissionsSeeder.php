<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin',
            'medico',
            'secretaria',
            'laboratorio',
            'farmacia',
            'paciente',
        ];

        $createdRoles = collect($roles)->mapWithKeys(function ($roleName) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            return [$roleName => $role];
        });

        $usersSeed = [
            [
                'nombre' => 'Admin',
                'apellido_paterno' => 'Sistema',
                'apellido_materno' => null,
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ],
            [
                'nombre' => 'Maria',
                'apellido_paterno' => 'Medica',
                'apellido_materno' => null,
                'email' => 'medico@example.com',
                'password' => bcrypt('password'),
                'role' => 'medico',
            ],
            [
                'nombre' => 'Laura',
                'apellido_paterno' => 'Secretaria',
                'apellido_materno' => null,
                'email' => 'secretaria@example.com',
                'password' => bcrypt('password'),
                'role' => 'secretaria',
            ],
            [
                'nombre' => 'Luis',
                'apellido_paterno' => 'Laboratorio',
                'apellido_materno' => null,
                'email' => 'laboratorio@example.com',
                'password' => bcrypt('password'),
                'role' => 'laboratorio',
            ],
            [
                'nombre' => 'Felipe',
                'apellido_paterno' => 'Farmacia',
                'apellido_materno' => null,
                'email' => 'farmacia@example.com',
                'password' => bcrypt('password'),
                'role' => 'farmacia',
            ],
            // Nota: no creamos usuario con rol paciente (sin acceso al sistema).
        ];

        foreach ($usersSeed as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'nombre' => $data['nombre'],
                    'apellido_paterno' => $data['apellido_paterno'],
                    'apellido_materno' => $data['apellido_materno'],
                    'password' => $data['password'],
                ]
            );

            $role = $createdRoles[$data['role']] ?? null;
            if ($role && ! $user->hasRole($role)) {
                $user->syncRoles([$role]);
            }
        }
    }
}
