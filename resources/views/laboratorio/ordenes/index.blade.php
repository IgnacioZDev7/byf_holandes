@extends('adminlte::page')

@section('title', 'Órdenes de laboratorio')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Órdenes de laboratorio</h1>
        <a href="{{ route('laboratorio.ordenes.create') }}" class="btn btn-primary">
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
                        <th>Fecha</th>
                        <th>Médico</th>
                        <th>Paciente</th>
                        <th>Urgencia</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ordenes as $orden)
                        <tr>
                            <td>{{ $orden->fecha_solicitud }}</td>
                            <td>{{ $orden->medico->nombre ?? '-' }}</td>
                            <td>{{ $orden->paciente->nombre ?? '-' }}</td>
                            <td>{{ $orden->urgencia }}</td>
                            <td class="text-end">
                                <a href="{{ route('laboratorio.ordenes.edit', $orden) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('laboratorio.ordenes.destroy', $orden) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar orden?');">
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
            {{ $ordenes->links() }}
        </div>
    </div>
@endsection
