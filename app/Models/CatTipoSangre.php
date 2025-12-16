<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatTipoSangre extends Model
{
    use HasFactory;

    protected $table = 'cat_tipos_sangre';

    protected $fillable = [
        'codigo',
        'descripcion',
    ];

    public $timestamps = false;
}