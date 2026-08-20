<?php

namespace App\Models;

use App\Models\Capacidad;
use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;
 
    protected $table = 'modelos';
    protected $primaryKey = 'id_modelo';

    protected $fillable = [
        'id_marca',
        'id_capacidad',
        'numero_serie',
        'nombre_modelo',
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    public function capacidad()
    {
        return $this->belongsTo(Capacidad::class, 'id_capacidad');
    }
}