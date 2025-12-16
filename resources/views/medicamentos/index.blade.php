@extends('adminlte::page')

@section('title', 'Medicamentos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Medicamentos</h1>
        <a href="{{ route('catalogos.medicamentos.create') }}" class="btn btn-primary">
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
            <form method="GET" action="{{ route('catalogos.medicamentos.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Nombre, descripción, principio activo...">
                </div>
                <div class="col-md-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select name="tipo" id="tipo" class="form-control">
                        <option value="">Todos</option>
                        <option value="analgesico" @selected(request('tipo') == 'analgesico')>Analgésico</option>
                        <option value="antibiotico" @selected(request('tipo') == 'antibiotico')>Antibiótico</option>
                        <option value="antihipertensivo" @selected(request('tipo') == 'antihipertensivo')>Antihipertensivo</option>
                        <option value="antidiabetico" @selected(request('tipo') == 'antidiabetico')>Antidiabético</option>
                        <option value="antiinflamatorio" @selected(request('tipo') == 'antiinflamatorio')>Antiinflamatorio</option>
                        <option value="vitamina" @selected(request('tipo') == 'vitamina')>Vitamina</option>
                        <option value="otro" @selected(request('tipo') == 'otro')>Otro</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="">Todos</option>
                        <option value="activo" @selected(request('estado') == 'activo')>Activo</option>
                        <option value="inactivo" @selected(request('estado') == 'inactivo')>Inactivo</option>
                    </select>
                </div>
                <div class="col-12 d-flex flex-wrap gap-2 justify-content-start justify-content-md-end pt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="{{ route('catalogos.medicamentos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Medicamentos</h3>
            <div class="card-tools">
                <span class="badge badge-info">{{ $medicamentos->total() }} medicamentos</span>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Presentación</th>
                        <th>Activa</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($medicamentos as $med)
                        <tr>
                            <td>{{ $med->nombre }}</td>
                            <td>{{ $med->presentacion ?? '-' }}</td>
                            <td>
                                @if($med->activa)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('catalogos.medicamentos.edit', $med) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('catalogos.medicamentos.destroy', $med) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar medicamento?');">
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
                            <td colspan="4" class="text-center">Sin registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $medicamentos->links() }}
        </div>
    </div>
@endsection
