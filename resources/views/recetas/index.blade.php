@extends('adminlte::page')

@section('title', 'Recetas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Recetas</h1>
        <a href="{{ route('recetas.create') }}" class="btn btn-primary">
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
                        <th>Consulta</th>
                        <th>Medicamento</th>
                        <th>Dosis</th>
                        <th>Frecuencia</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recetas as $receta)
                        <tr>
                            <td>#{{ $receta->consulta_id }}</td>
                            <td>{{ $receta->medicamento->nombre ?? '-' }}</td>
                            <td>{{ $receta->dosis }}</td>
                            <td>{{ $receta->frecuencia }}</td>
                            <td class="text-end">
                                <a href="{{ route('recetas.edit', $receta) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('recetas.destroy', $receta) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar receta?');">
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
            {{ $recetas->links() }}
        </div>
    </div>
@endsection
