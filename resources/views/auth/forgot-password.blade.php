@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', 'Restablecer contraseña')

@section('auth_body')
    <p class="text-muted mb-3">
        Ingresa tu correo y te enviaremos un enlace para restablecer la contraseña.
    </p>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="Correo electrónico" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-block">Enviar enlace</button>
    </form>
@endsection

@section('auth_footer')
    <a href="{{ route('login') }}">Volver al inicio de sesión</a>
@endsection
