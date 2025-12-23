@extends('adminlte::page')

@section('title', 'Consulta #' . $consulta->id)

@section('content_header')
    <h1>Consulta #{{ $consulta->id }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <p class="mb-1"><strong>Fecha:</strong> {{ $consulta->fecha }}</p>
                    <p class="mb-1"><strong>Hora:</strong> {{ $consulta->hora ?? '-' }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('consultas.pdf', $consulta) }}" class="btn btn-info" target="_blank">PDF</a>
                    <a href="{{ route('consultas.edit', $consulta) }}" class="btn btn-primary">Editar</a>
                    <a href="{{ route('consultas.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>

            <h4>Datos principales</h4>
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Médico:</strong> {{ $consulta->medico->nombre ?? '-' }} {{ $consulta->medico->apellido_paterno ?? '' }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Paciente:</strong> {{ $consulta->paciente->nombre ?? '-' }} {{ $consulta->paciente->apellido_paterno ?? '' }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Motivo:</strong> {{ $consulta->motivo }}</p>
                </div>
            </div>

            <h4 class="mt-3">Signos vitales y medidas</h4>
            <div class="row">
                <div class="col-md-3"><p><strong>Presión:</strong> {{ $consulta->presion_arterial ?? '-' }}</p></div>
                <div class="col-md-3"><p><strong>Temperatura:</strong> {{ $consulta->temperatura ? $consulta->temperatura . '°C' : '-' }}</p></div>
                <div class="col-md-3"><p><strong>FC:</strong> {{ $consulta->frecuencia_cardiaca ? $consulta->frecuencia_cardiaca . ' bpm' : '-' }}</p></div>
                <div class="col-md-3"><p><strong>FR:</strong> {{ $consulta->frecuencia_respiratoria ? $consulta->frecuencia_respiratoria . ' rpm' : '-' }}</p></div>
                <div class="col-md-3"><p><strong>Peso:</strong> {{ $consulta->peso ? $consulta->peso . ' kg' : '-' }}</p></div>
                <div class="col-md-3"><p><strong>Talla:</strong> {{ $consulta->talla ? $consulta->talla . ' m' : '-' }}</p></div>
                <div class="col-md-3"><p><strong>IMC:</strong> {{ $consulta->imc ? number_format($consulta->imc, 2) : '-' }}</p></div>
            </div>

            <h4 class="mt-3">Contenido clínico</h4>
            <p><strong>Diagnóstico:</strong><br>{{ $consulta->diagnostico ?? '-' }}</p>
            <p><strong>Tratamiento:</strong><br>{{ $consulta->tratamiento ?? '-' }}</p>
            <p><strong>Indicaciones al paciente:</strong><br>{{ $consulta->indicaciones_paciente ?? '-' }}</p>
            <p><strong>Evolución:</strong><br>{{ $consulta->evolucion ?? '-' }}</p>
            <p><strong>Notas adicionales:</strong><br>{{ $consulta->notas_adicionales ?? '-' }}</p>

            <h4 class="mt-3">Procedimientos</h4>
            @if($consulta->procedimientos->isEmpty())
                <p class="text-muted">Sin procedimientos asociados.</p>
            @else
                <ul>
                    @foreach($consulta->procedimientos as $proc)
                        <li>{{ $proc->codigo }} - {{ $proc->nombre }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
