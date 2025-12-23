@extends('adminlte::page')

@section('title', 'Historial médico')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Historial médico</h1>
        <a href="{{ route('historial-medico.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo
        </a>
    </div>
@endsection

@section('content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filtros de Búsqueda</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('historial-medico.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Resumen, diagnóstico, tratamiento, paciente...">
                </div>
                <div class="col-md-3">
                    <label for="paciente_id" class="form-label">Paciente</label>
                    <select name="paciente_id" id="paciente_id" class="form-control">
                        <option value="">Todos</option>
                        @foreach($pacientes as $paciente)
                            <option value="{{ $paciente->id }}" @selected(request('paciente_id') == $paciente->id)>
                                {{ $paciente->nombre }} {{ $paciente->apellido_paterno }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="fecha_desde" class="form-label">Fecha Desde</label>
                    <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                </div>
                <div class="col-md-2">
                    <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                </div>
                <div class="col-12 d-flex flex-wrap gap-2 justify-content-start justify-content-md-end pt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('historial-medico.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Historial Médico</h3>
            <div class="card-tools">
                <span class="badge badge-info">{{ $registros->total() }} registros</span>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Paciente</th>
                        <th>Resumen</th>
                        <th>Antecedentes</th>
                        <th>Hábitos/Medic.</th>
                        <th>Consulta</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registros as $reg)
                        <tr>
                            <td>{{ $reg->fecha }}</td>
                            <td>{{ $reg->paciente->nombre ?? '-' }}</td>
                            <td>{{ Str::limit($reg->resumen, 40) }}</td>
                            <td>
                                @php
                                    $anteced = $reg->antecedentes_personales ?: $reg->antecedentes_familiares;
                                @endphp
                                {{ $anteced ? Str::limit($anteced, 35) : '-' }}
                            </td>
                            <td>
                                @php
                                    $hab = $reg->habitos ?: $reg->medicamentos_actuales;
                                @endphp
                                {{ $hab ? Str::limit($hab, 35) : '-' }}
                            </td>
                            <td>{{ $reg->consulta_id ? '#'.$reg->consulta_id : '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('historial-medico.show', $reg) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('historial-medico.edit', $reg) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('historial-medico.destroy', $reg) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar registro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Sin registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $registros->links() }}
        </div>
    </div>
@endsection
