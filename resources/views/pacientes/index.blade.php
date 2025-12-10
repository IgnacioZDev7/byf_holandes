@extends('adminlte::page')

@section('title', 'Pacientes')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Pacientes</h1>
        <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo paciente
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
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Tipo sangre</th>
                        <th>Género</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pacientes as $paciente)
                        <tr>
                            <td>{{ $paciente->nombre }} {{ $paciente->apellido_paterno }}</td>
                            <td>{{ $paciente->email }}</td>
                            <td>{{ $paciente->telefono ?? '-' }}</td>
                            <td>{{ optional($paciente->perfilPaciente)->tipo_sangre_id ?? '-' }}</td>
                            <td>{{ optional($paciente->perfilPaciente)->genero_id ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('pacientes.edit', $paciente) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pacientes.destroy', $paciente) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar paciente?');">
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
                            <td colspan="6" class="text-center">Sin pacientes</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $pacientes->links() }}
        </div>
    </div>
@endsection
