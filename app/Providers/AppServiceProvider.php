<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
