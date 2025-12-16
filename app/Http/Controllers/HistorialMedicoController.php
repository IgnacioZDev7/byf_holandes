<?php

namespace App\Http\Controllers;

use App\Models\ConsultaMedica;
use App\Models\HistorialMedico;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HistorialMedicoController extends Controller
{
    public function index(Request $request)
    {
        $query = HistorialMedico::with(['paciente', 'consulta']);

        // Filtros
        if ($request->filled('paciente_id')) {
            $query->where('paciente_id', $request->paciente_id);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->fecha_hasta);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('resumen', 'like', "%{$search}%")
                  ->orWhere('diagnostico', 'like', "%{$search}%")
                  ->orWhere('tratamiento', 'like', "%{$search}%")
                  ->orWhereHas('paciente', function($pq) use ($search) {
                      $pq->where('nombre', 'like', "%{$search}%")
                         ->orWhere('apellido_paterno', 'like', "%{$search}%");
                  });
            });
        }

        $registros = $query->orderByDesc('fecha')->paginate(15)->withQueryString();

        // Datos para los filtros
        $pacientes = User::whereHas('roles', function($q) {
            $q->where('name', 'paciente');
        })->orderBy('nombre')->get();

        return view('historial.index', compact('registros', 'pacientes'));
    }

    public function create()
    {
        return $this->formResponse(new HistorialMedico(), 'create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        HistorialMedico::create($data);
        return redirect()->route('historial-medico.index')->with('status', 'Registro creado');
    }

    public function edit(HistorialMedico $historial_medico)
    {
        return $this->formResponse($historial_medico, 'edit');
    }

    public function update(Request $request, HistorialMedico $historial_medico): RedirectResponse
    {
        $data = $this->validateData($request);
        $historial_medico->update($data);
        return redirect()->route('historial-medico.index')->with('status', 'Registro actualizado');
    }

    public function destroy(HistorialMedico $historial_medico): RedirectResponse
    {
        $historial_medico->delete();
        return redirect()->route('historial-medico.index')->with('status', 'Registro eliminado');
    }

    protected function formResponse(HistorialMedico $registro, string $mode)
    {
        $pacientes = User::orderBy('nombre')->get();
        $consultas = ConsultaMedica::orderByDesc('fecha')->get();
        return view('historial.form', [
            'registro' => $registro,
            'pacientes' => $pacientes,
            'consultas' => $consultas,
            'mode' => $mode,
        ]);
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'paciente_id' => ['required', 'exists:users,id'],
            'fecha' => ['required', 'date'],
            'resumen' => ['required', 'string'],
            'diagnostico' => ['nullable', 'string'],
            'tratamiento' => ['nullable', 'string'],
            'consulta_id' => ['nullable', 'exists:consulta_medica,id'],
            'antecedentes_personales' => ['nullable', 'string'],
            'antecedentes_familiares' => ['nullable', 'string'],
            'habitos' => ['nullable', 'string'],
            'medicamentos_actuales' => ['nullable', 'string'],
            'alergias' => ['nullable', 'string'],
            'vacunas' => ['nullable', 'string'],
            'examenes_fisicos' => ['nullable', 'string'],
            'notas_importantes' => ['nullable', 'string'],
        ]);
    }
}
