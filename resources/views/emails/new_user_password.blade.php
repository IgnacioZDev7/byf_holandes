<p>Hola {{ $user->nombre }} {{ $user->apellido_paterno }},</p>

<p>Se creó tu acceso al sistema. Tus credenciales son:</p>
<ul>
    <li><strong>Correo:</strong> {{ $user->email }}</li>
    <li><strong>Contraseña temporal:</strong> {{ $plainPassword }}</li>
</ul>

<p>Te recomendamos cambiar la contraseña después de iniciar sesión.</p>

<p>Saludos.</p>
