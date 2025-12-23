@extends('adminlte::page')

@section('title', $mode === 'create' ? 'Nuevo turno' : 'Editar turno')

@section('content_header')
    <h1>{{ $mode === 'create' ? 'Nuevo turno' : 'Editar turno' }}</h1>
@endsection

@section('content')
    <div class="card shadow-sm mx-auto" style="max-width: 900px;">
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

            <form method="POST" action="{{ $mode === 'create' ? route('turnos.store') : route('turnos.update', $turno) }}">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="paciente_id">Paciente</label>
                            <select name="paciente_id" id="paciente_id" class="form-control" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($pacientes as $pac)
                                    <option value="{{ $pac->id }}" @selected(old('paciente_id', $turno->paciente_id) == $pac->id)>
                                        {{ $pac->nombre }} {{ $pac->apellido_paterno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="emision">Fecha y hora de emisión</label>
                            <input type="datetime-local" name="emision" id="emision" class="form-control" value="{{ old('emision', optional($turno->emision)->format('Y-m-d\\TH:i')) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="medico_id">Médico</label>
                            <select name="medico_id" id="medico_id" class="form-control">
                                <option value="">-- Seleccione --</option>
                                @foreach($medicos as $med)
                                    <option value="{{ $med->id }}" @selected(old('medico_id', $turno->medico_id) == $med->id)>
                                        {{ $med->nombre }} {{ $med->apellido_paterno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="especialidad_id">Especialidad</label>
                            <select name="especialidad_id" id="especialidad_id" class="form-control">
                                <option value="">-- Seleccione --</option>
                                @foreach($especialidades as $esp)
                                    <option value="{{ $esp->id }}" @selected(old('especialidad_id', $turno->especialidad_id) == $esp->id)>
                                        {{ $esp->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="motivo">Motivo</label>
                            <input type="text" name="motivo" id="motivo" class="form-control" value="{{ old('motivo', $turno->motivo) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="pendiente" @selected(old('estado', $turno->estado) == 'pendiente')>Pendiente</option>
                                <option value="confirmado" @selected(old('estado', $turno->estado) == 'confirmado')>Confirmado</option>
                                <option value="atendido" @selected(old('estado', $turno->estado) == 'atendido')>Atendido</option>
                                <option value="cancelado" @selected(old('estado', $turno->estado) == 'cancelado')>Cancelado</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="observaciones">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" class="form-control" rows="3">{{ old('observaciones', $turno->observaciones) }}</textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('turnos.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">{{ $mode === 'create' ? 'Crear' : 'Actualizar' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
