<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Direccion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'direcciones';

    protected $fillable = [
        'user_id',
        'zona',
        'calle',
        'nro',
        'referencia',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
