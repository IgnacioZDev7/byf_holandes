<?php

namespace App\Http\Controllers;

use App\Models\CatProcedimiento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProcedimientoController extends Controller
{
    public function index()
    {
        $procedimientos = CatProcedimiento::orderBy('codigo')->paginate(15);
        return view('procedimientos.index', compact('procedimientos'));
    }

    public function create()
    {
        return $this->formResponse(new CatProcedimiento(), 'create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        CatProcedimiento::create($data);
        return redirect()->route('procedimientos.index')->with('status', 'Procedimiento creado');
    }

    public function edit(CatProcedimiento $procedimiento)
    {
        return $this->formResponse($procedimiento, 'edit');
    }

    public function update(Request $request, CatProcedimiento $procedimiento): RedirectResponse
    {
        $data = $this->validateData($request, $procedimiento->id);
        $procedimiento->update($data);
        return redirect()->route('procedimientos.index')->with('status', 'Procedimiento actualizado');
    }

    public function destroy(CatProcedimiento $procedimiento): RedirectResponse
    {
        $procedimiento->delete();
        return redirect()->route('procedimientos.index')->with('status', 'Procedimiento eliminado');
    }

    protected function formResponse(CatProcedimiento $procedimiento, string $mode)
    {
        $areas = ['Consulta Externa', 'Emergencia', 'Hospitalizacion', 'Otros'];
        return view('procedimientos.form', compact('procedimiento', 'areas', 'mode'));
    }

    protected function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'codigo' => ['required', 'string', 'max:12', Rule::unique('cat_procedimientos', 'codigo')->ignore($id)],
            'nombre' => ['required', 'string', 'max:255'],
            'area' => ['required', Rule::in(['Consulta Externa', 'Emergencia', 'Hospitalizacion', 'Otros'])],
            'activa' => ['nullable', 'boolean'],
        ]);
    }
}
