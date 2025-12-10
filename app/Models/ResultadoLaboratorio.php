<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoLaboratorio extends Model
{
    use HasFactory;

    protected $table = 'resultado_laboratorio';

    public $timestamps = false;

    protected $fillable = [
        'prueba_id',
        'resultado',
        'valor_referencia',
        'emision',
        'created_at',
    ];

    protected $casts = [
        'emision' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function prueba()
    {
        return $this->belongsTo(OrdenPrueba::class, 'prueba_id');
    }
}
