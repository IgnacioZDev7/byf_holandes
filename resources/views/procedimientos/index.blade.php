@extends('adminlte::page')

@section('title', 'Procedimientos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Procedimientos</h1>
        <a href="{{ route('catalogos.procedimientos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo
        </a>
    </div>
@endsection

@section('content')
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Área</th>
                        <th>Activa</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($procedimientos as $procedimiento)
                        <tr>
                            <td>{{ $procedimiento->codigo }}</td>
                            <td>{{ $procedimiento->nombre }}</td>
                            <td>{{ $procedimiento->area }}</td>
                            <td>
                                @if($procedimiento->activa)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('catalogos.procedimientos.edit', $procedimiento) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('catalogos.procedimientos.destroy', $procedimiento) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar procedimiento?');">
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
            {{ $procedimientos->links() }}
        </div>
    </div>
@endsection
