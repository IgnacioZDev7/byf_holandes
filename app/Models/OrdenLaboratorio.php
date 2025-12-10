<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenLaboratorio extends Model
{
    use HasFactory;

    protected $table = 'orden_laboratorio';

    protected $fillable = [
        'consulta_id',
        'medico_id',
        'paciente_id',
        'fecha_solicitud',
        'numero_registro',
        'edad',
        'genero_id',
        'diagnosis_principal',
        'urgencia',
        'observaciones_generales',
    ];

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function consulta()
    {
        return $this->belongsTo(ConsultaMedica::class, 'consulta_id');
    }

    public function pruebas()
    {
        return $this->hasMany(OrdenPrueba::class, 'orden_id');
    }
}
