@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Usuarios</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo usuario
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
            <form method="GET" action="{{ route('users.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Nombre, email, teléfono, CI...">
                </div>
                <div class="col-md-2">
                    <label for="role" class="form-label">Rol</label>
                    <select name="role" id="role" class="form-control">
                        <option value="">Todos</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->name }}" @selected(request('role') == $rol->name)>
                                {{ ucfirst($rol->name) }}
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
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Usuarios</h3>
            <div class="card-tools">
                <span class="badge badge-info">{{ $users->total() }} usuarios</span>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Especialidad</th>
                        <th>Área</th>
                        <th>Roles</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->nombre }} {{ $user->apellido_paterno }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ optional($user->especialidad)->nombre ?? '-' }}</td>
                            <td>{{ $user->area_trabajo ?? '-' }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge bg-info">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td class="text-end">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar usuario?');">
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
                            <td colspan="6" class="text-center">Sin usuarios</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
@endsection
