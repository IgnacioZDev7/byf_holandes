@extends('adminlte::page')

@section('title', 'Pacientes')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Pacientes</h1>
        <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo paciente
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
            <form method="GET" action="{{ route('pacientes.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Nombre, email, teléfono, CI...">
                </div>
                <div class="col-md-2">
                    <label for="tipo_sangre" class="form-label">Tipo de Sangre</label>
                    <select name="tipo_sangre" id="tipo_sangre" class="form-control">
                        <option value="">Todos</option>
                        @foreach($tiposSangre as $tipo)
                            <option value="{{ $tipo->id }}" @selected(request('tipo_sangre') == $tipo->id)>{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="genero" class="form-label">Género</label>
                    <select name="genero" id="genero" class="form-control">
                        <option value="">Todos</option>
                        @foreach($generos as $gen)
                            <option value="{{ $gen->id }}" @selected(request('genero') == $gen->id)>{{ $gen->nombre }}</option>
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
                    <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Pacientes</h3>
            <div class="card-tools">
                <span class="badge badge-info">{{ $pacientes->total() }} pacientes</span>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Tipo sangre</th>
                        <th>Género</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pacientes as $paciente)
                        <tr>
                            <td>{{ $paciente->nombre }}</td>
                            <td>{{ trim($paciente->apellido_paterno . ' ' . ($paciente->apellido_materno ?? '')) }}</td>
                            <td>{{ $paciente->telefono ?? '-' }}</td>
                            <td>{{ $paciente->perfilPaciente?->tipoSangre?->codigo ?? '-' }}</td>
                            <td>{{ $paciente->perfilPaciente?->genero?->nombre ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $paciente->trashed() ? 'badge-secondary' : 'badge-success' }}">
                                    {{ $paciente->trashed() ? 'Inactivo' : 'Activo' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('pacientes.edit', $paciente) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pacientes.destroy', $paciente) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Cambiar estado del paciente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm {{ $paciente->trashed() ? 'btn-success' : 'btn-danger' }}">
                                        <i class="fas {{ $paciente->trashed() ? 'fa-undo' : 'fa-ban' }}"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Sin pacientes</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $pacientes->links() }}
        </div>
    </div>
@endsection
