@extends('adminlte::page')

@section('title', $mode === 'create' ? 'Nueva prueba de orden' : 'Editar prueba de orden')

@section('content_header')
    <h1>{{ $mode === 'create' ? 'Nueva prueba de orden' : 'Editar prueba de orden' }}</h1>
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

            <form method="POST" action="{{ $mode === 'create' ? route('laboratorio.pruebas.store') : route('laboratorio.pruebas.update', $prueba) }}">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="orden_id">Orden</label>
                            <select name="orden_id" id="orden_id" class="form-control" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($ordenes as $ord)
                                    <option value="{{ $ord->id }}" @selected(old('orden_id', $prueba->orden_id) == $ord->id)>#{{ $ord->id }} - Paciente: {{ $ord->paciente->nombre ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cat_prueba_id">Prueba</label>
                            <select name="cat_prueba_id" id="cat_prueba_id" class="form-control" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($catalogo as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('cat_prueba_id', $prueba->cat_prueba_id) == $cat->id)>{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="observaciones_especificas">Observaciones</label>
                    <textarea name="observaciones_especificas" id="observaciones_especificas" class="form-control" rows="2">{{ old('observaciones_especificas', $prueba->observaciones_especificas) }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('laboratorio.pruebas.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
