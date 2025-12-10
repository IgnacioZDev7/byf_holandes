@extends('adminlte::page')

@section('title', 'Consultas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Consultas</h1>
        <a href="{{ route('consultas.create') }}" class="btn btn-primary">
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
                        <th>Motivo</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultas as $consulta)
                        <tr>
                            <td>{{ $consulta->fecha }}</td>
                            <td>{{ $consulta->medico->nombre ?? '-' }}</td>
                            <td>{{ $consulta->paciente->nombre ?? '-' }}</td>
                            <td>{{ $consulta->motivo }}</td>
                            <td class="text-end">
                                <a href="{{ route('consultas.edit', $consulta) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('consultas.destroy', $consulta) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar consulta?');">
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
            {{ $consultas->links() }}
        </div>
    </div>
@endsection
