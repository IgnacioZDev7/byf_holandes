@extends('adminlte::page')

@section('title', 'Historial #' . $registro->id)

@section('content_header')
    <h1>Historial #{{ $registro->id }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <p class="mb-1"><strong>Fecha:</strong> {{ $registro->fecha }}</p>
                    <p class="mb-1"><strong>Paciente:</strong> {{ $registro->paciente->nombre ?? '-' }} {{ $registro->paciente->apellido_paterno ?? '' }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('historial-medico.pdf', $registro) }}" class="btn btn-info" target="_blank">PDF</a>
                    <a href="{{ route('historial-medico.edit', $registro) }}" class="btn btn-primary">Editar</a>
                    <a href="{{ route('historial-medico.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>

            <h4>Resumen y diagnóstico</h4>
            <p><strong>Resumen:</strong><br>{{ $registro->resumen }}</p>
            <p><strong>Diagnóstico:</strong><br>{{ $registro->diagnostico ?? '-' }}</p>
            <p><strong>Tratamiento:</strong><br>{{ $registro->tratamiento ?? '-' }}</p>

            <h4 class="mt-3">Campos detallados</h4>
            <div class="row">
                <div class="col-md-6"><p><strong>Antecedentes personales:</strong><br>{{ $registro->antecedentes_personales ?? '-' }}</p></div>
                <div class="col-md-6"><p><strong>Antecedentes familiares:</strong><br>{{ $registro->antecedentes_familiares ?? '-' }}</p></div>
                <div class="col-md-6"><p><strong>Hábitos:</strong><br>{{ $registro->habitos ?? '-' }}</p></div>
                <div class="col-md-6"><p><strong>Medicamentos actuales:</strong><br>{{ $registro->medicamentos_actuales ?? '-' }}</p></div>
                <div class="col-md-6"><p><strong>Alergias:</strong><br>{{ $registro->alergias ?? '-' }}</p></div>
                <div class="col-md-6"><p><strong>Vacunas:</strong><br>{{ $registro->vacunas ?? '-' }}</p></div>
                <div class="col-md-6"><p><strong>Exámenes físicos:</strong><br>{{ $registro->examenes_fisicos ?? '-' }}</p></div>
                <div class="col-md-6"><p><strong>Notas importantes:</strong><br>{{ $registro->notas_importantes ?? '-' }}</p></div>
            </div>

            <h4 class="mt-3">Referencia</h4>
            <p><strong>Consulta asociada:</strong> {{ $registro->consulta_id ? '#'.$registro->consulta_id : 'N/A' }}</p>
        </div>
    </div>
@endsection
