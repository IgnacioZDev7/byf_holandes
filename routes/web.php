<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProcedimientoController;
use App\Http\Controllers\CategoriaPruebaController;
use App\Http\Controllers\PruebaLaboratorioController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\RecetaTratamientoController;
use App\Http\Controllers\OrdenLaboratorioController;
use App\Http\Controllers\OrdenPruebaController;
use App\Http\Controllers\ResultadoLaboratorioController;
use App\Http\Controllers\FichaTurnoController;
use App\Http\Controllers\HistorialMedicoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    Route::middleware('role:admin|medico|secretaria')->group(function () {
        Route::resource('pacientes', PacienteController::class)
            ->parameters(['pacientes' => 'paciente'])
            ->withTrashed(['show', 'edit']);
        Route::resource('consultas', ConsultaController::class);
        Route::get('consultas/{consulta}/pdf', [ConsultaController::class, 'pdf'])->name('consultas.pdf');
        Route::get('consultas-export/pdf', [ConsultaController::class, 'exportPdf'])->name('consultas.export.pdf');
        Route::get('consultas-export/csv', [ConsultaController::class, 'exportCsv'])->name('consultas.export.csv');
        Route::resource('turnos', FichaTurnoController::class)->parameters(['turnos' => 'turno']);
        Route::get('turnos/{turno}/pdf', [FichaTurnoController::class, 'pdf'])->name('turnos.pdf');
        Route::patch('turnos/{turno}/estado', [FichaTurnoController::class, 'cambiarEstado'])->name('turnos.estado');
    });

    Route::middleware('role:admin|medico|farmacia')->group(function () {
        Route::resource('recetas', RecetaTratamientoController::class)->parameters(['recetas' => 'receta']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::prefix('catalogos')->name('catalogos.')->group(function () {
            Route::resource('procedimientos', ProcedimientoController::class)->parameters(['procedimientos' => 'procedimiento']);
            Route::resource('categorias-pruebas', CategoriaPruebaController::class)->parameters(['categorias-pruebas' => 'categorias_prueba']);
            Route::resource('pruebas', PruebaLaboratorioController::class)->parameters(['pruebas' => 'prueba']);
            Route::resource('especialidades', EspecialidadController::class)->parameters(['especialidades' => 'especialidade']);
            Route::resource('medicamentos', MedicamentoController::class)->parameters(['medicamentos' => 'medicamento']);
        });
    });

    Route::middleware('role:admin|laboratorio')->group(function () {
        Route::prefix('laboratorio')->name('laboratorio.')->group(function () {
            Route::resource('ordenes', OrdenLaboratorioController::class)->parameters(['ordenes' => 'ordene']);
            Route::resource('pruebas', OrdenPruebaController::class)->parameters(['pruebas' => 'prueba']);
            Route::resource('resultados', ResultadoLaboratorioController::class)->parameters(['resultados' => 'resultado']);
        });
    });

    Route::middleware('role:admin|medico')->group(function () {
        Route::resource('historial-medico', HistorialMedicoController::class)->parameters(['historial-medico' => 'historial_medico']);
        Route::get('historial-medico/{historial_medico}/pdf', [HistorialMedicoController::class, 'pdf'])->name('historial-medico.pdf');
    });
});

require __DIR__.'/auth.php';
