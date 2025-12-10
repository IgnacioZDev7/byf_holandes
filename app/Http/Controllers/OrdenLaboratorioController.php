<?php

namespace App\Http\Controllers;

use App\Models\ConsultaMedica;
use App\Models\OrdenLaboratorio;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrdenLaboratorioController extends Controller
{
    public function index()
    {
        $ordenes = OrdenLaboratorio::with(['medico', 'paciente'])->orderByDesc('fecha_solicitud')->paginate(15);
        return view('laboratorio.ordenes.index', compact('ordenes'));
    }

    public function create()
    {
        return $this->formResponse(new OrdenLaboratorio(), 'create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        OrdenLaboratorio::create($data);
        return redirect()->route('laboratorio.ordenes.index')->with('status', 'Orden creada');
    }

    public function edit(OrdenLaboratorio $ordene)
    {
        return $this->formResponse($ordene, 'edit');
    }

    public function update(Request $request, OrdenLaboratorio $ordene): RedirectResponse
    {
        $data = $this->validateData($request);
        $ordene->update($data);
        return redirect()->route('laboratorio.ordenes.index')->with('status', 'Orden actualizada');
    }

    public function destroy(OrdenLaboratorio $ordene): RedirectResponse
    {
        $ordene->delete();
        return redirect()->route('laboratorio.ordenes.index')->with('status', 'Orden eliminada');
    }

    protected function formResponse(OrdenLaboratorio $orden, string $mode)
    {
        $medicos = User::orderBy('nombre')->get();
        $pacientes = User::orderBy('nombre')->get();
        $consultas = ConsultaMedica::orderByDesc('fecha')->get();
        $generos = \DB::table('cat_generos')->orderBy('nombre')->get();
        $urgencias = ['Unidad/Servicio', 'Urgente', 'Programada'];

        return view('laboratorio.ordenes.form', compact('orden', 'medicos', 'pacientes', 'consultas', 'generos', 'urgencias', 'mode'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'consulta_id' => ['nullable', 'exists:consulta_medica,id'],
            'medico_id' => ['required', 'exists:users,id'],
            'paciente_id' => ['required', 'exists:users,id'],
            'fecha_solicitud' => ['required', 'date'],
            'numero_registro' => ['nullable', 'string', 'max:50'],
            'edad' => ['nullable', 'integer', 'min:0', 'max:255'],
            'genero_id' => ['nullable', 'exists:cat_generos,id'],
            'diagnosis_principal' => ['nullable', 'string'],
            'urgencia' => ['required', 'in:Unidad/Servicio,Urgente,Programada'],
            'observaciones_generales' => ['nullable', 'string'],
        ]);
    }
}
