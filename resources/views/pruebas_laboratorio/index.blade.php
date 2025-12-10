@extends('adminlte::page')

@section('title', 'Pruebas de laboratorio')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Pruebas de laboratorio</h1>
        <a href="{{ route('catalogos.pruebas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva
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
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Activa</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pruebas as $prueba)
                        <tr>
                            <td>{{ $prueba->nombre }}</td>
                            <td>{{ optional($prueba->categoria)->nombre }}</td>
                            <td>
                                @if($prueba->activa)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('catalogos.pruebas.edit', $prueba) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('catalogos.pruebas.destroy', $prueba) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar prueba?');">
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
            {{ $pruebas->links() }}
        </div>
    </div>
@endsection
