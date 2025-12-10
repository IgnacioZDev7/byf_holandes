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
