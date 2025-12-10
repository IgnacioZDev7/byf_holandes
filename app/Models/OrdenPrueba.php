<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenPrueba extends Model
{
    use HasFactory;

    protected $table = 'prueba_laboratorio';

    public $timestamps = false;

    protected $fillable = [
        'orden_id',
        'cat_prueba_id',
        'observaciones_especificas',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function orden()
    {
        return $this->belongsTo(OrdenLaboratorio::class, 'orden_id');
    }

    public function catalogoPrueba()
    {
        return $this->belongsTo(CatPruebaLaboratorio::class, 'cat_prueba_id');
    }

    public function resultado()
    {
        return $this->hasOne(ResultadoLaboratorio::class, 'prueba_id');
    }
}
