@extends('adminlte::page')

@section('title', 'Historial médico')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Historial médico</h1>
        <a href="{{ route('historial-medico.create') }}" class="btn btn-primary">
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
                        <th>Fecha</th>
                        <th>Paciente</th>
                        <th>Resumen</th>
                        <th>Consulta</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registros as $reg)
                        <tr>
                            <td>{{ $reg->fecha }}</td>
                            <td>{{ $reg->paciente->nombre ?? '-' }}</td>
                            <td>{{ Str::limit($reg->resumen, 40) }}</td>
                            <td>{{ $reg->consulta_id ? '#'.$reg->consulta_id : '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('historial-medico.edit', $reg) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('historial-medico.destroy', $reg) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar registro?');">
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
            {{ $registros->links() }}
        </div>
    </div>
@endsection
