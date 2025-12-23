<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso | Sistema Hospitalario</title>
    <link rel="stylesheet" href="{{ asset('css/health.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #0f766e;
            color: #0b3040;
        }
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.08), transparent 35%), radial-gradient(circle at 80% 0%, rgba(255,255,255,0.1), transparent 30%), linear-gradient(180deg, #0f766e, #0b524c);
            padding: 16px;
        }
        .auth-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
            max-width: 420px;
            width: 100%;
            padding: 26px;
        }
        .auth-header {
            text-align: center;
            margin-bottom: 16px;
        }
        .auth-header h1 {
            margin: 0;
            color: #0f766e;
        }
        .auth-header p {
            margin: 6px 0 0;
            color: #4a5568;
        }
        .form-group {
            margin-bottom: 14px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #2d3748;
        }
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
        }
        .form-control:focus {
            outline: 2px solid #0ea5e9;
        }
        .actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
        }
        .btn {
            border: none;
            border-radius: 8px;
            padding: 10px 14px;
            font-weight: 700;
            cursor: pointer;
        }
        .btn-primary {
            background: #0f766e;
            color: #fff;
            flex: 1;
            text-align: center;
        }
        .helper-links {
            margin-top: 10px;
            text-align: right;
        }
        .helper-links a {
            color: #0f766e;
            text-decoration: none;
            font-weight: 600;
        }
        .invalid-feedback {
            color: #e53e3e;
            font-size: 12px;
        }
        .alert-success {
            background: #e6fffa;
            color: #234e52;
            border: 1px solid #9ae6b4;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Hospital Salud</h1>
                <p>Acceso al sistema</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="usuario@correo.com" required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="actions">
                    <label style="display:flex; align-items:center; gap:6px; font-size:13px; color:#2d3748;">
                        <input type="checkbox" name="remember" style="width:14px; height:14px;"> Recordarme
                    </label>
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </div>
            </form>

            <div class="helper-links">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
