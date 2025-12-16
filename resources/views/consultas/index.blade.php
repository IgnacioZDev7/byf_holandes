@extends('adminlte::page')

@section('title', 'Consultas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Consultas</h1>
        <a href="{{ route('consultas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva
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
            <form method="GET" action="{{ route('consultas.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Motivo, paciente, médico...">
                </div>
                <div class="col-md-2">
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
                    <label for="medico_id" class="form-label">Médico</label>
                    <select name="medico_id" id="medico_id" class="form-control">
                        <option value="">Todos</option>
                        @foreach($medicos as $medico)
                            <option value="{{ $medico->id }}" @selected(request('medico_id') == $medico->id)>
                                {{ $medico->nombre }} {{ $medico->apellido_paterno }}
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
                    <a href="{{ route('consultas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Consultas</h3>
            <div class="card-tools">
                <span class="badge badge-info">{{ $consultas->total() }} consultas</span>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Médico</th>
                        <th>Paciente</th>
                        <th>Motivo</th>
                        <th>Presión</th>
                        <th>Temperatura</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultas as $consulta)
                        <tr>
                            <td>{{ $consulta->fecha }}</td>
                            <td>{{ $consulta->medico->nombre ?? '-' }}</td>
                            <td>{{ $consulta->paciente->nombre ?? '-' }}</td>
                            <td>{{ $consulta->motivo }}</td>
                            <td>{{ $consulta->presion_arterial ?? '-' }}</td>
                            <td>{{ $consulta->temperatura ? $consulta->temperatura . '°C' : '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('consultas.edit', $consulta) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('consultas.destroy', $consulta) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar consulta?');">
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
                            <td colspan="7" class="text-center">Sin consultas registradas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $consultas->links() }}
        </div>
    </div>
@endsection
