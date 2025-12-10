@extends('adminlte::page')

@section('title', $mode === 'create' ? 'Nuevo procedimiento' : 'Editar procedimiento')

@section('content_header')
    <h1>{{ $mode === 'create' ? 'Nuevo procedimiento' : 'Editar procedimiento' }}</h1>
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

            <form method="POST" action="{{ $mode === 'create' ? route('catalogos.procedimientos.store') : route('catalogos.procedimientos.update', $procedimiento) }}">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $procedimiento->codigo) }}" required>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $procedimiento->nombre) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="area">Área</label>
                            <select name="area" id="area" class="form-control" required>
                                @foreach($areas as $area)
                                    <option value="{{ $area }}" @selected(old('area', $procedimiento->area) == $area)>{{ $area }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="form-group mb-0">
                            <div class="form-check">
                                <input type="checkbox" name="activa" id="activa" class="form-check-input" value="1" @checked(old('activa', $procedimiento->activa))>
                                <label for="activa" class="form-check-label">Activa</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('catalogos.procedimientos.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
