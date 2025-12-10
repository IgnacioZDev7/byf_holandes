<?php

namespace App\Http\Controllers;

use App\Models\CatCategoriaPrueba;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriaPruebaController extends Controller
{
    public function index()
    {
        $categorias = CatCategoriaPrueba::orderBy('nombre')->paginate(15);
        return view('categorias_pruebas.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias_pruebas.form', ['categoria' => new CatCategoriaPrueba(), 'mode' => 'create']);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        CatCategoriaPrueba::create($data);
        return redirect()->route('catalogos.categorias-pruebas.index')->with('status', 'Categoría creada');
    }

    public function edit(CatCategoriaPrueba $categorias_prueba)
    {
        return view('categorias_pruebas.form', ['categoria' => $categorias_prueba, 'mode' => 'edit']);
    }

    public function update(Request $request, CatCategoriaPrueba $categorias_prueba): RedirectResponse
    {
        $data = $this->validateData($request, $categorias_prueba->id);
        $categorias_prueba->update($data);
        return redirect()->route('catalogos.categorias-pruebas.index')->with('status', 'Categoría actualizada');
    }

    public function destroy(CatCategoriaPrueba $categorias_prueba): RedirectResponse
    {
        $categorias_prueba->delete();
        return redirect()->route('catalogos.categorias-pruebas.index')->with('status', 'Categoría eliminada');
    }

    protected function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:100', Rule::unique('cat_categorias_pruebas', 'nombre')->ignore($id)],
        ]);
    }
}
