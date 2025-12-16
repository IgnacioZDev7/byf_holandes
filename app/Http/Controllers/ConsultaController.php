<?php

namespace App\Http\Controllers;

use App\Models\CatProcedimiento;
use App\Models\ConsultaMedica;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        $query = ConsultaMedica::with(['medico', 'paciente']);

        // Filtros
        if ($request->filled('paciente_id')) {
            $query->where('paciente_id', $request->paciente_id);
        }

        if ($request->filled('medico_id')) {
            $query->where('medico_id', $request->medico_id);
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
                $q->where('motivo', 'like', "%{$search}%")
                  ->orWhereHas('paciente', function($pq) use ($search) {
                      $pq->where('nombre', 'like', "%{$search}%")
                         ->orWhere('apellido_paterno', 'like', "%{$search}%");
                  })
                  ->orWhereHas('medico', function($mq) use ($search) {
                      $mq->where('nombre', 'like', "%{$search}%")
                         ->orWhere('apellido_paterno', 'like', "%{$search}%");
                  });
            });
        }

        $consultas = $query->orderByDesc('fecha')->paginate(15)->withQueryString();

        // Datos para los filtros
        $pacientes = User::whereHas('roles', function($q) {
            $q->where('name', 'paciente');
        })->orderBy('nombre')->get();

        $medicos = User::whereHas('roles', function($q) {
            $q->where('name', 'doctor');
        })->orderBy('nombre')->get();

        return view('consultas.index', compact('consultas', 'pacientes', 'medicos'));
    }

    public function create()
    {
        return $this->formResponse(new ConsultaMedica(), 'create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);

        $consulta = ConsultaMedica::create($data);
        $consulta->procedimientos()->sync($data['procedimientos'] ?? []);

        return redirect()->route('consultas.index')->with('status', 'Consulta creada');
    }

    public function edit(ConsultaMedica $consulta)
    {
        return $this->formResponse($consulta, 'edit');
    }

    public function update(Request $request, ConsultaMedica $consulta): RedirectResponse
    {
        $data = $this->validateData($request, $consulta->id);

        $consulta->update($data);
        $consulta->procedimientos()->sync($data['procedimientos'] ?? []);

        return redirect()->route('consultas.index')->with('status', 'Consulta actualizada');
    }

    public function destroy(ConsultaMedica $consulta): RedirectResponse
    {
        $consulta->delete();
        return redirect()->route('consultas.index')->with('status', 'Consulta eliminada');
    }

    protected function formResponse(ConsultaMedica $consulta, string $mode)
    {
        $medicos = User::orderBy('nombre')->get();
        $pacientes = User::orderBy('nombre')->get();
        $procedimientos = CatProcedimiento::orderBy('area')->orderBy('nombre')->get()->groupBy('area');

        return view('consultas.form', compact('consulta', 'medicos', 'pacientes', 'procedimientos', 'mode'));
    }

    protected function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'medico_id' => ['required', 'exists:users,id'],
            'paciente_id' => ['required', 'exists:users,id'],
            'fecha' => ['required', 'date'],
            'hora' => ['nullable', 'date_format:H:i'],
            'motivo' => ['required', 'string', 'max:255'],
            'diagnostico' => ['nullable', 'string'],
            'tratamiento' => ['nullable', 'string'],
            'indicaciones_paciente' => ['nullable', 'string'],
            'procedimientos' => ['nullable', 'array'],
            'procedimientos.*' => ['exists:cat_procedimientos,id'],
            'presion_arterial' => ['nullable', 'string', 'max:20'],
            'temperatura' => ['nullable', 'numeric', 'min:30', 'max:45'],
            'frecuencia_cardiaca' => ['nullable', 'integer', 'min:40', 'max:200'],
            'frecuencia_respiratoria' => ['nullable', 'integer', 'min:10', 'max:60'],
            'peso' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'talla' => ['nullable', 'numeric', 'min:0.5', 'max:2.5'],
            'imc' => ['nullable', 'numeric', 'min:10', 'max:60'],
            'evolucion' => ['nullable', 'string'],
            'notas_adicionales' => ['nullable', 'string'],
        ]);
    }
}
