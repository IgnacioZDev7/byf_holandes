@extends('adminlte::page')

@section('title', $mode === 'create' ? 'Nueva especialidad' : 'Editar especialidad')

@section('content_header')
    <h1>{{ $mode === 'create' ? 'Nueva especialidad' : 'Editar especialidad' }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ $mode === 'create' ? route('catalogos.especialidades.store') : route('catalogos.especialidades.update', $especialidad) }}">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $especialidad->nombre) }}" required>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" name="activa" id="activa" class="form-check-input" value="1" @checked(old('activa', $especialidad->activa))>
                    <label for="activa" class="form-check-label">Activa</label>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('catalogos.especialidades.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
