<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecetaTratamiento extends Model
{
    use HasFactory;

    protected $table = 'receta_tratamiento';

    public $timestamps = false;

    protected $fillable = [
        'consulta_id',
        'medicamento_id',
        'dosis',
        'frecuencia',
        'duracion',
        'indicaciones',
        'cantidad_recetada',
        'cantidad_dispensada',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function consulta()
    {
        return $this->belongsTo(ConsultaMedica::class, 'consulta_id');
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'medicamento_id');
    }
}
