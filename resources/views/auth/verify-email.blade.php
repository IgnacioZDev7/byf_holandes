@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', 'Verificar correo')

@section('auth_body')
    <p class="text-muted mb-3">
        Te enviamos un enlace de verificación a tu correo. Si no lo recibiste, puedes solicitar otro.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            Se envió un nuevo enlace de verificación.
        </div>
    @endif

    <div class="d-flex justify-content-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Reenviar enlace</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link">Cerrar sesión</button>
        </form>
    </div>
@endsection
