<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EspecialidadController extends Controller
{
    public function index()
    {
        $especialidades = Especialidad::orderBy('nombre')->paginate(15);
        return view('especialidades.index', compact('especialidades'));
    }

    public function create()
    {
        return view('especialidades.form', ['especialidad' => new Especialidad(), 'mode' => 'create']);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        Especialidad::create($data);
        return redirect()->route('catalogos.especialidades.index')->with('status', 'Especialidad creada');
    }

    public function edit(Especialidad $especialidade)
    {
        return view('especialidades.form', ['especialidad' => $especialidade, 'mode' => 'edit']);
    }

    public function update(Request $request, Especialidad $especialidade): RedirectResponse
    {
        $data = $this->validateData($request, $especialidade->id);
        $especialidade->update($data);
        return redirect()->route('catalogos.especialidades.index')->with('status', 'Especialidad actualizada');
    }

    public function destroy(Especialidad $especialidade): RedirectResponse
    {
        $especialidade->delete();
        return redirect()->route('catalogos.especialidades.index')->with('status', 'Especialidad eliminada');
    }

    protected function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:100', Rule::unique('especialidades', 'nombre')->ignore($id)],
            'activa' => ['nullable', 'boolean'],
        ]);
    }
}
