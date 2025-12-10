<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaTurno extends Model
{
    use HasFactory;

    protected $table = 'ficha_turno';

    public $timestamps = false;

    protected $fillable = [
        'paciente_id',
        'emision',
        'created_at',
    ];

    protected $casts = [
        'emision' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }
}
