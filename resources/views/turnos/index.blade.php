@extends('adminlte::page')

@section('title', 'Turnos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Turnos</h1>
        <a href="{{ route('turnos.create') }}" class="btn btn-primary">
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
            <form method="GET" action="{{ route('turnos.index') }}" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Paciente, médico, especialidad...">
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
                    <label for="especialidad_id" class="form-label">Especialidad</label>
                    <select name="especialidad_id" id="especialidad_id" class="form-control">
                        <option value="">Todas</option>
                        @foreach($especialidades as $especialidad)
                            <option value="{{ $especialidad->id }}" @selected(request('especialidad_id') == $especialidad->id)>
                                {{ $especialidad->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="">Todos</option>
                        <option value="pendiente" @selected(request('estado') == 'pendiente')>Pendiente</option>
                        <option value="confirmado" @selected(request('estado') == 'confirmado')>Confirmado</option>
                        <option value="atendido" @selected(request('estado') == 'atendido')>Atendido</option>
                        <option value="cancelado" @selected(request('estado') == 'cancelado')>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="fecha_desde" class="form-label">Desde</label>
                    <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                </div>
                <div class="col-md-2">
                    <label for="fecha_hasta" class="form-label">Hasta</label>
                    <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                </div>
                <div class="col-12 d-flex flex-wrap gap-2 justify-content-start justify-content-md-end pt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('turnos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Turnos</h3>
            <div class="card-tools">
                <span class="badge badge-info">{{ $turnos->total() }} turnos</span>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Especialidad</th>
                        <th>Estado</th>
                        <th>Emisión</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($turnos as $turno)
                        <tr>
                            <td>{{ $turno->paciente->nombre ?? '-' }} {{ $turno->paciente->apellido_paterno ?? '' }}</td>
                            <td>{{ $turno->medico->nombre ?? '-' }} {{ $turno->medico->apellido_paterno ?? '' }}</td>
                            <td>{{ $turno->especialidad->nombre ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $turno->estado == 'pendiente' ? 'warning' : ($turno->estado == 'confirmado' ? 'info' : ($turno->estado == 'atendido' ? 'success' : 'danger')) }}">
                                    {{ ucfirst($turno->estado) }}
                                </span>
                            </td>
                            <td>{{ optional($turno->emision)->format('d/m/Y H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('turnos.pdf', $turno) }}" class="btn btn-sm btn-info" target="_blank">
                                    <i class="fas fa-print"></i> PDF
                                </a>
                                <a href="{{ route('turnos.edit', $turno) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('turnos.destroy', $turno) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar turno?');">
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
                            <td colspan="6" class="text-center">Sin registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $turnos->links() }}
        </div>
    </div>
@endsection
