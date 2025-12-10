<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultaMedica extends Model
{
    use HasFactory;

    protected $table = 'consulta_medica';

    protected $fillable = [
        'medico_id',
        'paciente_id',
        'fecha',
        'hora',
        'motivo',
        'diagnostico',
        'tratamiento',
        'indicaciones_paciente',
    ];

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function procedimientos()
    {
        return $this->belongsToMany(CatProcedimiento::class, 'consulta_procedimientos', 'consulta_id', 'procedimiento_id')->withPivot('observaciones');
    }

    public function recetas()
    {
        return $this->hasMany(RecetaTratamiento::class, 'consulta_id');
    }
}
