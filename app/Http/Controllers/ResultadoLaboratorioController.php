<?php

namespace App\Http\Controllers;

use App\Models\OrdenPrueba;
use App\Models\ResultadoLaboratorio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ResultadoLaboratorioController extends Controller
{
    public function index()
    {
        $resultados = ResultadoLaboratorio::with(['prueba.orden'])->orderByDesc('emision')->paginate(15);
        return view('laboratorio.resultados.index', compact('resultados'));
    }

    public function create()
    {
        return $this->formResponse(new ResultadoLaboratorio(), 'create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        ResultadoLaboratorio::create($data);
        return redirect()->route('laboratorio.resultados.index')->with('status', 'Resultado guardado');
    }

    public function edit(ResultadoLaboratorio $resultado)
    {
        return $this->formResponse($resultado, 'edit');
    }

    public function update(Request $request, ResultadoLaboratorio $resultado): RedirectResponse
    {
        $data = $this->validateData($request);
        $resultado->update($data);
        return redirect()->route('laboratorio.resultados.index')->with('status', 'Resultado actualizado');
    }

    public function destroy(ResultadoLaboratorio $resultado): RedirectResponse
    {
        $resultado->delete();
        return redirect()->route('laboratorio.resultados.index')->with('status', 'Resultado eliminado');
    }

    protected function formResponse(ResultadoLaboratorio $resultado, string $mode)
    {
        $pruebas = OrdenPrueba::with('orden')->orderByDesc('created_at')->get();
        return view('laboratorio.resultados.form', compact('resultado', 'pruebas', 'mode'));
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'prueba_id' => ['required', 'exists:prueba_laboratorio,id'],
            'resultado' => ['required', 'string'],
            'valor_referencia' => ['nullable', 'string', 'max:255'],
            'emision' => ['required', 'date'],
        ]);
    }
}
