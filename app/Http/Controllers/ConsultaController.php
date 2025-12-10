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
    public function index()
    {
        $consultas = ConsultaMedica::with(['medico', 'paciente'])->orderByDesc('fecha')->paginate(15);
        return view('consultas.index', compact('consultas'));
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
        $procedimientos = CatProcedimiento::orderBy('nombre')->get();

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
        ]);
    }
}
