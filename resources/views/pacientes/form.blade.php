@extends('adminlte::page')

@section('title', $mode === 'create' ? 'Nuevo paciente' : 'Editar paciente')

@section('content_header')
    <h1>{{ $mode === 'create' ? 'Nuevo paciente' : 'Editar paciente' }}</h1>
@endsection

@section('content')
    <div class="card shadow-sm mx-auto" style="max-width: 1100px;">
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

            <form method="POST" action="{{ $mode === 'create' ? route('pacientes.store') : route('pacientes.update', $user) }}">
                @csrf
                @if($mode === 'edit')
                    @method('PUT')
                @endif

                <h4>Datos personales</h4>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $user->nombre) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="apellido_paterno">Apellido paterno</label>
                            <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" value="{{ old('apellido_paterno', $user->apellido_paterno) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="apellido_materno">Apellido materno</label>
                            <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" value="{{ old('apellido_materno', $user->apellido_materno) }}">
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ci">CI</label>
                            <input type="text" name="ci" id="ci" class="form-control" value="{{ old('ci', $user->ci) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', $user->telefono) }}">
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tipo_sangre_id">Tipo de sangre</label>
                            <select name="tipo_sangre_id" id="tipo_sangre_id" class="form-control">
                                <option value="">-- Seleccione --</option>
                                @foreach($tiposSangre as $tipo)
                                    <option value="{{ $tipo->id }}" @selected(old('tipo_sangre_id', $perfil->tipo_sangre_id) == $tipo->id)>
                                        {{ $tipo->codigo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nacionalidad_id">Nacionalidad</label>
                            <select name="nacionalidad_id" id="nacionalidad_id" class="form-control">
                                <option value="">-- Seleccione --</option>
                                @foreach($nacionalidades as $nac)
                                    <option value="{{ $nac->id }}" @selected(old('nacionalidad_id', $perfil->nacionalidad_id) == $nac->id)>
                                        {{ $nac->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="estado_civil_id">Estado civil</label>
                            <select name="estado_civil_id" id="estado_civil_id" class="form-control">
                                <option value="">-- Seleccione --</option>
                                @foreach($estadosCiviles as $ec)
                                    <option value="{{ $ec->id }}" @selected(old('estado_civil_id', $perfil->estado_civil_id) == $ec->id)>
                                        {{ $ec->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="genero_id">Género</label>
                            <select name="genero_id" id="genero_id" class="form-control">
                                <option value="">-- Seleccione --</option>
                                @foreach($generos as $gen)
                                    <option value="{{ $gen->id }}" @selected(old('genero_id', $perfil->genero_id) == $gen->id)>
                                        {{ $gen->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="alergias">Alergias</label>
                            <textarea name="alergias" id="alergias" class="form-control" rows="2">{{ old('alergias', $perfil->alergias) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="enfermedades_cronicas">Enfermedades crónicas</label>
                            <textarea name="enfermedades_cronicas" id="enfermedades_cronicas" class="form-control" rows="2">{{ old('enfermedades_cronicas', $perfil->enfermedades_cronicas) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" class="form-control" rows="2">{{ old('observaciones', $perfil->observaciones) }}</textarea>
                        </div>
                    </div>
                </div>

                <h4>Dirección</h4>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="zona">Zona</label>
                            <input type="text" name="zona" id="zona" class="form-control" value="{{ old('zona', $direccion->zona) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="calle">Calle</label>
                            <input type="text" name="calle" id="calle" class="form-control" value="{{ old('calle', $direccion->calle) }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="nro">Nro</label>
                            <input type="text" name="nro" id="nro" class="form-control" value="{{ old('nro', $direccion->nro) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="referencia">Referencia</label>
                            <input type="text" name="referencia" id="referencia" class="form-control" value="{{ old('referencia', $direccion->referencia) }}">
                        </div>
                    </div>
                </div>

                <h4>Contacto de emergencia</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contacto_nombre">Nombre</label>
                            <input type="text" name="contacto_nombre" id="contacto_nombre" class="form-control" value="{{ old('contacto_nombre', $contacto->nombre) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contacto_telefono">Teléfono</label>
                            <input type="text" name="contacto_telefono" id="contacto_telefono" class="form-control" value="{{ old('contacto_telefono', $contacto->telefono) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="parentesco_id">Parentesco</label>
                            <select name="parentesco_id" id="parentesco_id" class="form-control">
                                <option value="">-- Seleccione --</option>
                                @foreach($parentescos as $par)
                                    <option value="{{ $par->id }}" @selected(old('parentesco_id', $contacto->parentesco_id) == $par->id)>{{ $par->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('pacientes.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
