@extends('adminlte::page')

@section('title', $mode === 'create' ? 'Nuevo turno' : 'Editar turno')

@section('content_header')
    <h1>{{ $mode === 'create' ? 'Nuevo turno' : 'Editar turno' }}</h1>
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

            <form method="POST" action="{{ $mode === 'create' ? route('turnos.store') : route('turnos.update', $turno) }}">
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
                            <input type="datetime-local" name="emision" id="emision" class="form-control" value="{{ old('emision', optional($turno->emision)->format('Y-m-d\TH:i')) }}" required>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('turnos.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
