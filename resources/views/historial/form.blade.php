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

                <hr>
                <h4>Información Detallada del Historial Médico</h4>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="antecedentes_personales">Antecedentes Personales</label>
                            <textarea name="antecedentes_personales" id="antecedentes_personales" class="form-control" rows="3" placeholder="Enfermedades previas, cirugías, etc.">{{ old('antecedentes_personales', $registro->antecedentes_personales) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="antecedentes_familiares">Antecedentes Familiares</label>
                            <textarea name="antecedentes_familiares" id="antecedentes_familiares" class="form-control" rows="3" placeholder="Enfermedades en la familia">{{ old('antecedentes_familiares', $registro->antecedentes_familiares) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="habitos">Hábitos</label>
                            <textarea name="habitos" id="habitos" class="form-control" rows="3" placeholder="Fumar, alcohol, ejercicio, etc.">{{ old('habitos', $registro->habitos) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="medicamentos_actuales">Medicamentos Actuales</label>
                            <textarea name="medicamentos_actuales" id="medicamentos_actuales" class="form-control" rows="3" placeholder="Medicamentos que toma actualmente">{{ old('medicamentos_actuales', $registro->medicamentos_actuales) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="alergias">Alergias</label>
                            <textarea name="alergias" id="alergias" class="form-control" rows="3" placeholder="Alergias conocidas">{{ old('alergias', $registro->alergias) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vacunas">Vacunas</label>
                            <textarea name="vacunas" id="vacunas" class="form-control" rows="3" placeholder="Historial de vacunación">{{ old('vacunas', $registro->vacunas) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="examenes_fisicos">Exámenes Físicos</label>
                            <textarea name="examenes_fisicos" id="examenes_fisicos" class="form-control" rows="3" placeholder="Resultados de exámenes físicos">{{ old('examenes_fisicos', $registro->examenes_fisicos) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="notas_importantes">Notas Importantes</label>
                            <textarea name="notas_importantes" id="notas_importantes" class="form-control" rows="3" placeholder="Observaciones adicionales">{{ old('notas_importantes', $registro->notas_importantes) }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
