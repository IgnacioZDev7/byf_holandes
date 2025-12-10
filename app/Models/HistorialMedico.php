<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialMedico extends Model
{
    use HasFactory;

    protected $table = 'historial_medico';

    protected $fillable = [
        'paciente_id',
        'fecha',
        'resumen',
        'diagnostico',
        'tratamiento',
        'consulta_id',
    ];

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function consulta()
    {
        return $this->belongsTo(ConsultaMedica::class, 'consulta_id');
    }
}
