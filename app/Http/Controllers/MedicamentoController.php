<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MedicamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicamento::query();

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%")
                  ->orWhere('principio_activo', 'like', "%{$search}%")
                  ->orWhere('laboratorio', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $medicamentos = $query->orderBy('nombre')->paginate(15)->withQueryString();

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
