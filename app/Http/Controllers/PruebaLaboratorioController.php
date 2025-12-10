<?php

namespace App\Http\Controllers;

use App\Models\CatCategoriaPrueba;
use App\Models\CatPruebaLaboratorio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PruebaLaboratorioController extends Controller
{
    public function index()
    {
        $pruebas = CatPruebaLaboratorio::with('categoria')->orderBy('nombre')->paginate(15);
        return view('pruebas_laboratorio.index', compact('pruebas'));
    }

    public function create()
    {
        return $this->formResponse(new CatPruebaLaboratorio(), 'create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        CatPruebaLaboratorio::create($data);
        return redirect()->route('catalogos.pruebas.index')->with('status', 'Prueba creada');
    }

    public function edit(CatPruebaLaboratorio $prueba)
    {
        return $this->formResponse($prueba, 'edit');
    }

    public function update(Request $request, CatPruebaLaboratorio $prueba): RedirectResponse
    {
        $data = $this->validateData($request, $prueba->id);
        $prueba->update($data);
        return redirect()->route('catalogos.pruebas.index')->with('status', 'Prueba actualizada');
    }

    public function destroy(CatPruebaLaboratorio $prueba): RedirectResponse
    {
        $prueba->delete();
        return redirect()->route('catalogos.pruebas.index')->with('status', 'Prueba eliminada');
    }

    protected function formResponse(CatPruebaLaboratorio $prueba, string $mode)
    {
        $categorias = CatCategoriaPrueba::orderBy('nombre')->get();
        return view('pruebas_laboratorio.form', compact('prueba', 'categorias', 'mode'));
    }

    protected function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'categoria_id' => ['required', 'exists:cat_categorias_pruebas,id'],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'activa' => ['nullable', 'boolean'],
        ]);
    }
}
