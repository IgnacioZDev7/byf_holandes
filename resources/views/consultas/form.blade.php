@extends('adminlte::page')

@section('title', $mode === 'create' ? 'Nueva consulta' : 'Editar consulta')

@section('content_header')
    <h1>{{ $mode === 'create' ? 'Nueva consulta' : 'Editar consulta' }}</h1>
@endsection

@section('plugins.Select2', true)

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

                <h4 class="mt-4">Signos Vitales</h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="presion_arterial">Presión Arterial</label>
                            <input type="text" name="presion_arterial" id="presion_arterial" class="form-control" value="{{ old('presion_arterial', $consulta->presion_arterial) }}" placeholder="120/80">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="temperatura">Temperatura (°C)</label>
                            <input type="number" name="temperatura" id="temperatura" class="form-control" step="0.1" value="{{ old('temperatura', $consulta->temperatura) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="frecuencia_cardiaca">Frecuencia Cardíaca (bpm)</label>
                            <input type="number" name="frecuencia_cardiaca" id="frecuencia_cardiaca" class="form-control" value="{{ old('frecuencia_cardiaca', $consulta->frecuencia_cardiaca) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="frecuencia_respiratoria">Frecuencia Respiratoria (rpm)</label>
                            <input type="number" name="frecuencia_respiratoria" id="frecuencia_respiratoria" class="form-control" value="{{ old('frecuencia_respiratoria', $consulta->frecuencia_respiratoria) }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="peso">Peso (kg)</label>
                            <input type="number" name="peso" id="peso" class="form-control" step="0.01" value="{{ old('peso', $consulta->peso) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="talla">Talla (m)</label>
                            <input type="number" name="talla" id="talla" class="form-control" step="0.01" value="{{ old('talla', $consulta->talla) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="imc">IMC</label>
                            <input type="number" name="imc" id="imc" class="form-control" step="0.01" value="{{ old('imc', $consulta->imc) }}" readonly>
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
                    <label for="evolucion">Evolución</label>
                    <textarea name="evolucion" id="evolucion" class="form-control" rows="3">{{ old('evolucion', $consulta->evolucion) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="notas_adicionales">Notas Adicionales</label>
                    <textarea name="notas_adicionales" id="notas_adicionales" class="form-control" rows="2">{{ old('notas_adicionales', $consulta->notas_adicionales) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="procedimientos">Procedimientos</label>
                    <select name="procedimientos[]" id="procedimientos" class="form-control select2" multiple>
                        @foreach($procedimientos as $area => $procs)
                            <optgroup label="{{ $area }}">
                                @foreach($procs as $proc)
                                    <option value="{{ $proc->id }}" @selected(collect(old('procedimientos', $consulta->procedimientos->pluck('id')->toArray()))->contains($proc->id))>
                                        {{ $proc->codigo }} - {{ $proc->nombre }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('consultas.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#procedimientos').select2({
            placeholder: 'Seleccione procedimientos',
            allowClear: true,
            width: '100%'
        });

        // Calcular IMC automáticamente
        function calcularIMC() {
            var peso = parseFloat($('#peso').val());
            var talla = parseFloat($('#talla').val());
            if (peso > 0 && talla > 0) {
                var imc = peso / (talla * talla);
                $('#imc').val(imc.toFixed(2));
            } else {
                $('#imc').val('');
            }
        }

        $('#peso, #talla').on('input', calcularIMC);
    });
</script>
@endsection
