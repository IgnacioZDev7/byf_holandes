@extends('adminlte::page')

@section('title', $mode === 'create' ? 'Nueva receta' : 'Editar receta')

@section('content_header')
    <h1>{{ $mode === 'create' ? 'Nueva receta' : 'Editar receta' }}</h1>
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

            <form method="POST" action="{{ $mode === 'create' ? route('recetas.store') : route('recetas.update', $receta) }}">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="consulta_id">Consulta</label>
                            <select name="consulta_id" id="consulta_id" class="form-control" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($consultas as $cons)
                                    <option value="{{ $cons->id }}" @selected(old('consulta_id', $receta->consulta_id) == $cons->id)>
                                        #{{ $cons->id }} - Paciente: {{ $cons->paciente->nombre ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="medicamento_id">Medicamento</label>
                            <select name="medicamento_id" id="medicamento_id" class="form-control" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($medicamentos as $med)
                                    <option value="{{ $med->id }}" @selected(old('medicamento_id', $receta->medicamento_id) == $med->id)>{{ $med->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dosis">Dosis</label>
                            <input type="text" name="dosis" id="dosis" class="form-control" value="{{ old('dosis', $receta->dosis) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="frecuencia">Frecuencia</label>
                            <input type="text" name="frecuencia" id="frecuencia" class="form-control" value="{{ old('frecuencia', $receta->frecuencia) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="duracion">Duración</label>
                            <input type="text" name="duracion" id="duracion" class="form-control" value="{{ old('duracion', $receta->duracion) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cantidad_recetada">Cantidad recetada</label>
                            <input type="number" name="cantidad_recetada" id="cantidad_recetada" class="form-control" value="{{ old('cantidad_recetada', $receta->cantidad_recetada) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="indicaciones">Indicaciones</label>
                    <textarea name="indicaciones" id="indicaciones" class="form-control" rows="2">{{ old('indicaciones', $receta->indicaciones) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cantidad_dispensada">Cantidad dispensada</label>
                            <input type="number" name="cantidad_dispensada" id="cantidad_dispensada" class="form-control" value="{{ old('cantidad_dispensada', $receta->cantidad_dispensada) }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('recetas.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
