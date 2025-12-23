<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Vincular pacientes incluyendo soft deletes
        Route::bind('paciente', function ($value) {
            return User::withTrashed()->findOrFail($value);
        });

        \Gate::define('view-users', function ($user) {
            return $user->hasRole('admin');
        });

        \Gate::define('view-pacientes', function ($user) {
            return $user->hasRole(['admin', 'medico', 'secretaria']);
        });

        \Gate::define('view-consultas', function ($user) {
            return $user->hasRole(['admin', 'medico', 'secretaria']);
        });

        \Gate::define('view-laboratorio', function ($user) {
            return $user->hasRole(['admin', 'laboratorio']);
        });

        \Gate::define('view-turnos', function ($user) {
            return $user->hasRole(['admin', 'medico', 'secretaria']);
        });

        \Gate::define('view-recetas', function ($user) {
            return $user->hasRole(['admin', 'medico', 'farmacia']);
        });

        \Gate::define('view-historial', function ($user) {
            return $user->hasRole(['admin', 'medico']);
        });

        \Gate::define('view-catalogos', function ($user) {
            return $user->hasRole('admin');
        });

        \Gate::define('view-procedimientos', function ($user) {
            return $user->hasRole('admin');
        });

        \Gate::define('view-pruebas', function ($user) {
            return $user->hasRole('admin');
        });

        \Gate::define('view-medicamentos', function ($user) {
            return $user->hasRole('admin');
        });

        \Gate::define('view-especialidades', function ($user) {
            return $user->hasRole('admin');
        });
    }
}
