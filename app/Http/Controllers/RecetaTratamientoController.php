<?php

namespace App\Http\Controllers;

use App\Models\ConsultaMedica;
use App\Models\Medicamento;
use App\Models\RecetaTratamiento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RecetaTratamientoController extends Controller
{
    public function index()
    {
        $recetas = RecetaTratamiento::with(['consulta', 'medicamento'])->orderByDesc('created_at')->paginate(15);
        return view('recetas.index', compact('recetas'));
    }

    public function create()
    {
        return $this->formResponse(new RecetaTratamiento(), 'create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        RecetaTratamiento::create($data);
        return redirect()->route('recetas.index')->with('status', 'Receta creada');
    }

    public function edit(RecetaTratamiento $receta)
    {
        return $this->formResponse($receta, 'edit');
    }

    public function update(Request $request, RecetaTratamiento $receta): RedirectResponse
    {
        $data = $this->validateData($request);
        $receta->update($data);
        return redirect()->route('recetas.index')->with('status', 'Receta actualizada');
    }

    public function destroy(RecetaTratamiento $receta): RedirectResponse
    {
        $receta->delete();
        return redirect()->route('recetas.index')->with('status', 'Receta eliminada');
    }

    protected function formResponse(RecetaTratamiento $receta, string $mode)
    {
        $consultas = ConsultaMedica::with(['paciente'])->orderByDesc('fecha')->get();
        $medicamentos = Medicamento::orderBy('nombre')->get();

        return view('recetas.form', compact('receta', 'consultas', 'medicamentos', 'mode'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'consulta_id' => ['required', 'exists:consulta_medica,id'],
            'medicamento_id' => ['required', 'exists:medicamentos,id'],
            'dosis' => ['required', 'string', 'max:255'],
            'frecuencia' => ['required', 'string', 'max:100'],
            'duracion' => ['nullable', 'string', 'max:100'],
            'indicaciones' => ['nullable', 'string'],
            'cantidad_recetada' => ['nullable', 'integer', 'min:0'],
            'cantidad_dispensada' => ['nullable', 'integer', 'min:0'],
        ]);
    }
}
