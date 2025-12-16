<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Turno - {{ $turno->paciente->nombre }} {{ $turno->paciente->apellido_paterno }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section h3 {
            background-color: #f8f9fa;
            padding: 5px;
            margin: 0 0 10px 0;
            border-left: 4px solid #007bff;
        }
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        .label {
            font-weight: bold;
            width: 150px;
        }
        .value {
            flex: 1;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Hospital/Clínica BYF Holandes</h1>
        <h2>Ficha de Turno</h2>
    </div>

    <div class="info-section">
        <h3>Información del Paciente</h3>
        <div class="info-row">
            <span class="label">Nombre:</span>
            <span class="value">{{ $turno->paciente->nombre }} {{ $turno->paciente->apellido_paterno }} {{ $turno->paciente->apellido_materno }}</span>
        </div>
        <div class="info-row">
            <span class="label">CI:</span>
            <span class="value">{{ $turno->paciente->ci ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Teléfono:</span>
            <span class="value">{{ $turno->paciente->telefono ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Email:</span>
            <span class="value">{{ $turno->paciente->email ?? 'N/A' }}</span>
        </div>
    </div>

    <div class="info-section">
        <h3>Detalles del Turno</h3>
        <div class="info-row">
            <span class="label">Fecha de Emisión:</span>
            <span class="value">{{ $turno->emision ? $turno->emision->format('d/m/Y H:i') : 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Médico Asignado:</span>
            <span class="value">{{ $turno->medico ? $turno->medico->nombre . ' ' . $turno->medico->apellido_paterno : 'No asignado' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Especialidad:</span>
            <span class="value">{{ $turno->especialidad ? $turno->especialidad->nombre : 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Motivo:</span>
            <span class="value">{{ $turno->motivo ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="label">Estado:</span>
            <span class="value">{{ ucfirst($turno->estado ?? 'pendiente') }}</span>
        </div>
    </div>

    <div class="info-section">
        <h3>Observaciones</h3>
        <p>{{ $turno->observaciones ?? 'Sin observaciones adicionales' }}</p>
    </div>

    <div class="footer">
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
        <p>Hospital/Clínica BYF Holandes - Sistema de Gestión Médica</p>
    </div>
</body>
</html>