@extends('adminlte::page')

@section('title', 'Categorías de Pruebas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Categorías de Pruebas</h1>
        <a href="{{ route('catalogos.categorias-pruebas.create') }}" class="btn btn-primary">
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
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categorias as $cat)
                        <tr>
                            <td>{{ $cat->nombre }}</td>
                            <td class="text-end">
                                <a href="{{ route('catalogos.categorias-pruebas.edit', $cat) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('catalogos.categorias-pruebas.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar categoría?');">
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
                            <td colspan="2" class="text-center">Sin registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $categorias->links() }}
        </div>
    </div>
@endsection
