@extends('adminlte::page')

@section('title', $mode === 'create' ? 'Nueva orden' : 'Editar orden')

@section('content_header')
    <h1>{{ $mode === 'create' ? 'Nueva orden de laboratorio' : 'Editar orden de laboratorio' }}</h1>
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

            <form method="POST" action="{{ $mode === 'create' ? route('laboratorio.ordenes.store') : route('laboratorio.ordenes.update', $orden) }}">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="medico_id">Médico</label>
                            <select name="medico_id" id="medico_id" class="form-control" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($medicos as $medico)
                                    <option value="{{ $medico->id }}" @selected(old('medico_id', $orden->medico_id) == $medico->id)>{{ $medico->nombre }} {{ $medico->apellido_paterno }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="paciente_id">Paciente</label>
                            <select name="paciente_id" id="paciente_id" class="form-control" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}" @selected(old('paciente_id', $orden->paciente_id) == $paciente->id)>{{ $paciente->nombre }} {{ $paciente->apellido_paterno }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="consulta_id">Consulta (opcional)</label>
                            <select name="consulta_id" id="consulta_id" class="form-control">
                                <option value="">-- Seleccione --</option>
                                @foreach($consultas as $cons)
                                    <option value="{{ $cons->id }}" @selected(old('consulta_id', $orden->consulta_id) == $cons->id)>#{{ $cons->id }} - {{ $cons->fecha }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="fecha_solicitud">Fecha solicitud</label>
                            <input type="date" name="fecha_solicitud" id="fecha_solicitud" class="form-control" value="{{ old('fecha_solicitud', $orden->fecha_solicitud) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="numero_registro">Número registro</label>
                            <input type="text" name="numero_registro" id="numero_registro" class="form-control" value="{{ old('numero_registro', $orden->numero_registro) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="number" name="edad" id="edad" class="form-control" value="{{ old('edad', $orden->edad) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="genero_id">Género</label>
                            <select name="genero_id" id="genero_id" class="form-control">
                                <option value="">-- Seleccione --</option>
                                @foreach($generos as $gen)
                                    <option value="{{ $gen->id }}" @selected(old('genero_id', $orden->genero_id) == $gen->id)>{{ $gen->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="urgencia">Urgencia</label>
                            <select name="urgencia" id="urgencia" class="form-control" required>
                                @foreach($urgencias as $urg)
                                    <option value="{{ $urg }}" @selected(old('urgencia', $orden->urgencia) == $urg)>{{ $urg }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="diagnosis_principal">Diagnóstico principal</label>
                            <textarea name="diagnosis_principal" id="diagnosis_principal" class="form-control" rows="2">{{ old('diagnosis_principal', $orden->diagnosis_principal) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="observaciones_generales">Observaciones generales</label>
                    <textarea name="observaciones_generales" id="observaciones_generales" class="form-control" rows="2">{{ old('observaciones_generales', $orden->observaciones_generales) }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('laboratorio.ordenes.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
