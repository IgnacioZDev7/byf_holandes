<?php

namespace App\Http\Controllers;

use App\Models\FichaTurno;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FichaTurnoController extends Controller
{
    public function index()
    {
        $turnos = FichaTurno::with('paciente')->orderByDesc('emision')->paginate(15);
        return view('turnos.index', compact('turnos'));
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

    protected function formResponse(FichaTurno $turno, string $mode)
    {
        $pacientes = User::orderBy('nombre')->get();
        return view('turnos.form', compact('turno', 'pacientes', 'mode'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'paciente_id' => ['required', 'exists:users,id'],
            'emision' => ['required', 'date'],
        ]);
    }
}
