@extends('adminlte::page')

@section('title', $mode === 'create' ? 'Nueva prueba' : 'Editar prueba')

@section('content_header')
    <h1>{{ $mode === 'create' ? 'Nueva prueba' : 'Editar prueba' }}</h1>
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

            <form method="POST" action="{{ $mode === 'create' ? route('catalogos.pruebas.store') : route('catalogos.pruebas.update', $prueba) }}">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $prueba->nombre) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="categoria_id">Categoría</label>
                            <select name="categoria_id" id="categoria_id" class="form-control" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" @selected(old('categoria_id', $prueba->categoria_id) == $cat->id)>{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion', $prueba->descripcion) }}</textarea>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" name="activa" id="activa" class="form-check-input" value="1" @checked(old('activa', $prueba->activa))>
                    <label for="activa" class="form-check-label">Activa</label>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('catalogos.pruebas.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
