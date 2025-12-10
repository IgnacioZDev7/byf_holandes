<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MedicamentoController extends Controller
{
    public function index()
    {
        $medicamentos = Medicamento::orderBy('nombre')->paginate(15);
        return view('medicamentos.index', compact('medicamentos'));
    }

    public function create()
    {
        return view('medicamentos.form', ['medicamento' => new Medicamento(), 'mode' => 'create']);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        Medicamento::create($data);
        return redirect()->route('catalogos.medicamentos.index')->with('status', 'Medicamento creado');
    }

    public function edit(Medicamento $medicamento)
    {
        return view('medicamentos.form', ['medicamento' => $medicamento, 'mode' => 'edit']);
    }

    public function update(Request $request, Medicamento $medicamento): RedirectResponse
    {
        $data = $this->validateData($request, $medicamento->id);
        $medicamento->update($data);
        return redirect()->route('catalogos.medicamentos.index')->with('status', 'Medicamento actualizado');
    }

    public function destroy(Medicamento $medicamento): RedirectResponse
    {
        $medicamento->delete();
        return redirect()->route('catalogos.medicamentos.index')->with('status', 'Medicamento eliminado');
    }

    protected function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:200', Rule::unique('medicamentos', 'nombre')->ignore($id)],
            'presentacion' => ['nullable', 'string', 'max:100'],
            'activa' => ['nullable', 'boolean'],
        ]);
    }
}
