@extends('adminlte::page')

@section('title', 'Resultados de laboratorio')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Resultados de laboratorio</h1>
        <a href="{{ route('laboratorio.resultados.create') }}" class="btn btn-primary">
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
                        <th>Prueba</th>
                        <th>Orden</th>
                        <th>Resultado</th>
                        <th>Emisión</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resultados as $res)
                        <tr>
                            <td>{{ $res->prueba->catalogoPrueba->nombre ?? '-' }}</td>
                            <td>#{{ $res->prueba->orden_id ?? '-' }}</td>
                            <td>{{ Str::limit($res->resultado, 40) }}</td>
                            <td>{{ optional($res->emision)->format('Y-m-d H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('laboratorio.resultados.edit', $res) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('laboratorio.resultados.destroy', $res) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar resultado?');">
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
            {{ $resultados->links() }}
        </div>
    </div>
@endsection
