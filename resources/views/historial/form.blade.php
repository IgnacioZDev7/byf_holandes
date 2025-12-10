@extends('adminlte::page')

@section('title', $mode === 'create' ? 'Nuevo historial' : 'Editar historial')

@section('content_header')
    <h1>{{ $mode === 'create' ? 'Nuevo historial' : 'Editar historial' }}</h1>
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

            <form method="POST" action="{{ $mode === 'create' ? route('historial-medico.store') : route('historial-medico.update', $registro) }}">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="paciente_id">Paciente</label>
                            <select name="paciente_id" id="paciente_id" class="form-control" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($pacientes as $pac)
                                    <option value="{{ $pac->id }}" @selected(old('paciente_id', $registro->paciente_id) == $pac->id)>
                                        {{ $pac->nombre }} {{ $pac->apellido_paterno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $registro->fecha) }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="consulta_id">Consulta (opcional)</label>
                            <select name="consulta_id" id="consulta_id" class="form-control">
                                <option value="">-- Seleccione --</option>
                                @foreach($consultas as $cons)
                                    <option value="{{ $cons->id }}" @selected(old('consulta_id', $registro->consulta_id) == $cons->id)>#{{ $cons->id }} - {{ $cons->fecha }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="resumen">Resumen</label>
                    <textarea name="resumen" id="resumen" class="form-control" rows="2" required>{{ old('resumen', $registro->resumen) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="diagnostico">Diagnóstico</label>
                    <textarea name="diagnostico" id="diagnostico" class="form-control" rows="2">{{ old('diagnostico', $registro->diagnostico) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="tratamiento">Tratamiento</label>
                    <textarea name="tratamiento" id="tratamiento" class="form-control" rows="2">{{ old('tratamiento', $registro->tratamiento) }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('historial-medico.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
