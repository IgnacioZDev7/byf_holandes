@extends('adminlte::page')

@section('title', 'Pruebas de orden')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Pruebas de órdenes</h1>
        <a href="{{ route('laboratorio.pruebas.create') }}" class="btn btn-primary">
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
                        <th>Orden</th>
                        <th>Prueba</th>
                        <th>Observaciones</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pruebas as $prueba)
                        <tr>
                            <td>#{{ $prueba->orden_id }}</td>
                            <td>{{ $prueba->catalogoPrueba->nombre ?? '-' }}</td>
                            <td>{{ $prueba->observaciones_especificas ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('laboratorio.pruebas.edit', $prueba) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('laboratorio.pruebas.destroy', $prueba) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar prueba?');">
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
