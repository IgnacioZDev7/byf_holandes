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
            color: #2d3748;
            background: #f5f7fa;
        }
        .card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0a7c7b;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .header h1 {
            color: #0a7c7b;
            margin: 0;
            font-size: 22px;
        }
        .header p {
            margin: 4px 0 0;
            color: #4a5568;
            font-size: 12px;
        }
        .pill {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 6px;
            background: #edf2f7;
            font-weight: bold;
            font-size: 12px;
            color: #2d3748;
            margin-top: 6px;
        }
        .section-title {
            margin: 16px 0 8px;
            font-size: 14px;
            color: #2d3748;
            border-left: 4px solid #0a7c7b;
            padding-left: 8px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px 16px;
        }
        .item {
            font-size: 13px;
            line-height: 1.4;
        }
        .label {
            font-weight: bold;
            color: #4a5568;
        }
        .value {
            color: #1a202c;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 6px;
            color: #fff;
            font-weight: bold;
            font-size: 12px;
            background: #0a7c7b;
        }
        .footer {
            margin-top: 22px;
            text-align: center;
            font-size: 11px;
            color: #718096;
        }
        .notes {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px;
            font-size: 13px;
        }
        .qr-box {
            border: 1px dashed #cbd5e0;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            margin-top: 8px;
            font-size: 12px;
            color: #4a5568;
        }
        .signatures {
            margin-top: 18px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            font-size: 12px;
        }
        .signatures .line {
            border-top: 1px solid #cbd5e0;
            padding-top: 6px;
            text-align: center;
            color: #4a5568;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>Hospital/Clínica BYF Holandes</h1>
            <p>Ficha de Turno</p>
            <div class="pill">N.º {{ $turno->id }}</div>
        </div>

        <div class="section">
            <div class="section-title">Información del Paciente</div>
            <div class="grid">
                <div class="item"><span class="label">Nombre: </span><span class="value">{{ $turno->paciente->nombre }} {{ $turno->paciente->apellido_paterno }} {{ $turno->paciente->apellido_materno }}</span></div>
                <div class="item"><span class="label">CI: </span><span class="value">{{ $turno->paciente->ci ?? 'N/A' }}</span></div>
                <div class="item"><span class="label">Teléfono: </span><span class="value">{{ $turno->paciente->telefono ?? 'N/A' }}</span></div>
                <div class="item"><span class="label">Email: </span><span class="value">{{ $turno->paciente->email ?? 'N/A' }}</span></div>
                <div class="item"><span class="label">Tipo de sangre: </span><span class="value">{{ $turno->paciente->perfilPaciente?->tipoSangre?->codigo ?? 'N/A' }}</span></div>
                <div class="item"><span class="label">Género: </span><span class="value">{{ $turno->paciente->perfilPaciente?->genero?->nombre ?? 'N/A' }}</span></div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Detalles del Turno</div>
            <div class="grid">
                <div class="item"><span class="label">Fecha de emisión: </span><span class="value">{{ $turno->emision ? $turno->emision->format('d/m/Y H:i') : 'N/A' }}</span></div>
                <div class="item"><span class="label">Estado: </span><span class="badge">{{ ucfirst($turno->estado ?? 'pendiente') }}</span></div>
                <div class="item"><span class="label">Especialidad: </span><span class="value">{{ $turno->especialidad?->nombre ?? 'N/A' }}</span></div>
                <div class="item"><span class="label">Médico asignado: </span><span class="value">{{ ($turno->medico?->nombre . ' ' . $turno->medico?->apellido_paterno) ?? 'No asignado' }}</span></div>
                <div class="item"><span class="label">Motivo: </span><span class="value">{{ $turno->motivo ?? 'N/A' }}</span></div>
            </div>
            <div class="qr-box">
                Código de verificación: <strong>TUR-{{ str_pad($turno->id, 6, '0', STR_PAD_LEFT) }}</strong><br>
                Presente este código al momento de la atención.
            </div>
        </div>

        <div class="section">
            <div class="section-title">Observaciones</div>
            <div class="notes">
                {{ $turno->observaciones ?? 'Sin observaciones adicionales' }}
            </div>
        </div>

        <div class="footer">
            <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
            <p>Hospital/Clínica BYF Holandes - Sistema de Gestión Médica</p>
        </div>

        <div class="signatures">
            <div class="line">Firma del paciente</div>
            <div class="line">Firma del personal</div>
        </div>
    </div>
</body>
</html>
