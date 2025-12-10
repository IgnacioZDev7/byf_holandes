<?php

namespace App\Http\Controllers;

use App\Models\CatPruebaLaboratorio;
use App\Models\OrdenLaboratorio;
use App\Models\OrdenPrueba;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrdenPruebaController extends Controller
{
    public function index()
    {
        $pruebas = OrdenPrueba::with(['orden', 'catalogoPrueba'])->orderByDesc('created_at')->paginate(15);
        return view('laboratorio.pruebas.index', compact('pruebas'));
    }

    public function create()
    {
        return $this->formResponse(new OrdenPrueba(), 'create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        OrdenPrueba::create($data);
        return redirect()->route('laboratorio.pruebas.index')->with('status', 'Prueba agregada');
    }

    public function edit(OrdenPrueba $prueba)
    {
        return $this->formResponse($prueba, 'edit');
    }

    public function update(Request $request, OrdenPrueba $prueba): RedirectResponse
    {
        $data = $this->validateData($request);
        $prueba->update($data);
        return redirect()->route('laboratorio.pruebas.index')->with('status', 'Prueba actualizada');
    }

    public function destroy(OrdenPrueba $prueba): RedirectResponse
    {
        $prueba->delete();
        return redirect()->route('laboratorio.pruebas.index')->with('status', 'Prueba eliminada');
    }

    protected function formResponse(OrdenPrueba $prueba, string $mode)
    {
        $ordenes = OrdenLaboratorio::orderByDesc('fecha_solicitud')->get();
        $catalogo = CatPruebaLaboratorio::orderBy('nombre')->get();
        return view('laboratorio.pruebas.form', compact('prueba', 'ordenes', 'catalogo', 'mode'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'orden_id' => ['required', 'exists:orden_laboratorio,id'],
            'cat_prueba_id' => ['required', 'exists:cat_pruebas_laboratorio,id'],
            'observaciones_especificas' => ['nullable', 'string'],
        ]);
    }
}
