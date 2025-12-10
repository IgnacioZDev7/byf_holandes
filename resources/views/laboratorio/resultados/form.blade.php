@extends('adminlte::page')

@section('title', $mode === 'create' ? 'Nuevo resultado' : 'Editar resultado')

@section('content_header')
    <h1>{{ $mode === 'create' ? 'Nuevo resultado' : 'Editar resultado' }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ $mode === 'create' ? route('laboratorio.resultados.store') : route('laboratorio.resultados.update', $resultado) }}">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="prueba_id">Prueba</label>
                    <select name="prueba_id" id="prueba_id" class="form-control" required>
                        <option value="">-- Seleccione --</option>
                        @foreach($pruebas as $pr)
                            <option value="{{ $pr->id }}" @selected(old('prueba_id', $resultado->prueba_id) == $pr->id)>
                                #{{ $pr->id }} - {{ $pr->catalogoPrueba->nombre ?? '' }} (Orden #{{ $pr->orden_id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="resultado">Resultado</label>
                    <textarea name="resultado" id="resultado" class="form-control" rows="3" required>{{ old('resultado', $resultado->resultado) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="valor_referencia">Valor de referencia</label>
                    <input type="text" name="valor_referencia" id="valor_referencia" class="form-control" value="{{ old('valor_referencia', $resultado->valor_referencia) }}">
                </div>

                <div class="form-group">
                    <label for="emision">Fecha y hora de emisión</label>
                    <input type="datetime-local" name="emision" id="emision" class="form-control" value="{{ old('emision', optional($resultado->emision)->format('Y-m-d\TH:i')) }}" required>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('laboratorio.resultados.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
