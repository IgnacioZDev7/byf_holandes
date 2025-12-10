@extends('adminlte::page')

@section('title', $mode === 'create' ? 'Nueva consulta' : 'Editar consulta')

@section('content_header')
    <h1>{{ $mode === 'create' ? 'Nueva consulta' : 'Editar consulta' }}</h1>
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

            <form method="POST" action="{{ $mode === 'create' ? route('consultas.store') : route('consultas.update', $consulta) }}">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="medico_id">Médico</label>
                            <select name="medico_id" id="medico_id" class="form-control" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($medicos as $medico)
                                    <option value="{{ $medico->id }}" @selected(old('medico_id', $consulta->medico_id) == $medico->id)>
                                        {{ $medico->nombre }} {{ $medico->apellido_paterno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="paciente_id">Paciente</label>
                            <select name="paciente_id" id="paciente_id" class="form-control" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}" @selected(old('paciente_id', $consulta->paciente_id) == $paciente->id)>
                                        {{ $paciente->nombre }} {{ $paciente->apellido_paterno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $consulta->fecha) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="hora">Hora</label>
                            <input type="time" name="hora" id="hora" class="form-control" value="{{ old('hora', $consulta->hora) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="motivo">Motivo</label>
                            <input type="text" name="motivo" id="motivo" class="form-control" value="{{ old('motivo', $consulta->motivo) }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="diagnostico">Diagnóstico</label>
                    <textarea name="diagnostico" id="diagnostico" class="form-control" rows="2">{{ old('diagnostico', $consulta->diagnostico) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="tratamiento">Tratamiento</label>
                    <textarea name="tratamiento" id="tratamiento" class="form-control" rows="2">{{ old('tratamiento', $consulta->tratamiento) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="indicaciones_paciente">Indicaciones al paciente</label>
                    <textarea name="indicaciones_paciente" id="indicaciones_paciente" class="form-control" rows="2">{{ old('indicaciones_paciente', $consulta->indicaciones_paciente) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="procedimientos">Procedimientos</label>
                    <select name="procedimientos[]" id="procedimientos" class="form-control" multiple>
                        @foreach($procedimientos as $proc)
                            <option value="{{ $proc->id }}" @selected(collect(old('procedimientos', $consulta->procedimientos->pluck('id')->toArray()))->contains($proc->id))>
                                {{ $proc->codigo }} - {{ $proc->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Use Ctrl/Cmd para seleccionar varios.</small>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('consultas.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
