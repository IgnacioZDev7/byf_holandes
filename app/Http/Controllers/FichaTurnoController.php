<?php

namespace App\Http\Controllers;

use App\Models\FichaTurno;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FichaTurnoController extends Controller
{
    public function index(Request $request)
    {
        $query = FichaTurno::with(['paciente', 'medico', 'especialidad']);

        // Filtros
        if ($request->filled('paciente_id')) {
            $query->where('paciente_id', $request->paciente_id);
        }

        if ($request->filled('medico_id')) {
            $query->where('medico_id', $request->medico_id);
        }

        if ($request->filled('especialidad_id')) {
            $query->where('especialidad_id', $request->especialidad_id);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('emision', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('emision', '<=', $request->fecha_hasta);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('paciente', function($pq) use ($search) {
                    $pq->where('nombre', 'like', "%{$search}%")
                       ->orWhere('apellido_paterno', 'like', "%{$search}%");
                })
                ->orWhereHas('medico', function($mq) use ($search) {
                    $mq->where('nombre', 'like', "%{$search}%")
                       ->orWhere('apellido_paterno', 'like', "%{$search}%");
                })
                ->orWhereHas('especialidad', function($eq) use ($search) {
                    $eq->where('nombre', 'like', "%{$search}%");
                });
            });
        }

        $turnos = $query->orderByDesc('emision')->paginate(15)->withQueryString();

        // Datos para los filtros
        $pacientes = User::whereHas('roles', function($q) {
            $q->where('name', 'paciente');
        })->orderBy('nombre')->get();

        $medicos = User::whereHas('roles', function($q) {
            $q->where('name', 'medico');
        })->orderBy('nombre')->get();

        $especialidades = \App\Models\Especialidad::orderBy('nombre')->get();

        return view('turnos.index', compact('turnos', 'pacientes', 'medicos', 'especialidades'));
    }

    public function create()
    {
        return $this->formResponse(new FichaTurno(), 'create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        FichaTurno::create($data);
        return redirect()->route('turnos.index')->with('status', 'Turno creado');
    }

    public function edit(FichaTurno $turno)
    {
        return $this->formResponse($turno, 'edit');
    }

    public function update(Request $request, FichaTurno $turno): RedirectResponse
    {
        $data = $this->validateData($request);
        $turno->update($data);
        return redirect()->route('turnos.index')->with('status', 'Turno actualizado');
    }

    public function destroy(FichaTurno $turno): RedirectResponse
    {
        $turno->delete();
        return redirect()->route('turnos.index')->with('status', 'Turno eliminado');
    }

    public function cambiarEstado(Request $request, FichaTurno $turno): RedirectResponse
    {
        $data = $request->validate([
            'estado' => ['required', 'in:pendiente,confirmado,atendido,cancelado'],
        ]);

        $turno->estado = $data['estado'];
        $turno->save();

        return redirect()->route('turnos.index')->with('status', 'Estado actualizado');
    }

    public function pdf(FichaTurno $turno)
    {
        $turno->load([
            'paciente.perfilPaciente.tipoSangre',
            'paciente.perfilPaciente.genero',
            'medico',
            'especialidad',
        ]);

        $pdf = \PDF::loadView('turnos.ficha_pdf', compact('turno'));
        return $pdf->download('ficha_turno_' . $turno->id . '.pdf');
    }

    protected function formResponse(FichaTurno $turno, string $mode)
    {
        $pacientes = User::whereHas('roles', function($q) {
            $q->where('name', 'paciente');
        })->orderBy('nombre')->get();

        $medicos = User::whereHas('roles', function($q) {
            $q->where('name', 'medico');
        })->orderBy('nombre')->get();
        $especialidades = \App\Models\Especialidad::orderBy('nombre')->get();
        return view('turnos.form', compact('turno', 'pacientes', 'medicos', 'especialidades', 'mode'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'paciente_id' => ['required', 'exists:users,id'],
            'medico_id' => ['nullable', 'exists:users,id'],
            'especialidad_id' => ['nullable', 'exists:especialidades,id'],
            'emision' => ['required', 'date'],
            'motivo' => ['nullable', 'string', 'max:255'],
            'estado' => ['nullable', 'in:pendiente,confirmado,atendido,cancelado'],
            'observaciones' => ['nullable', 'string'],
        ]);
    }
}
