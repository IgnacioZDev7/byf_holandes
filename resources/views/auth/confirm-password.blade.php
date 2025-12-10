@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', 'Confirmar contraseña')

@section('auth_body')
    <p class="text-muted mb-3">
        Área segura del sistema. Ingresa tu contraseña para continuar.
    </p>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="Contraseña" required autocomplete="current-password">
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-block">Confirmar</button>
    </form>
@endsection

@section('auth_footer')
    <a href="{{ route('login') }}">Volver al inicio de sesión</a>
@endsection
