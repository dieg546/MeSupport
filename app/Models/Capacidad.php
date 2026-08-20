<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacidad extends Model
{
    use HasFactory;

    protected $table = 'capacidades';
    protected $primaryKey = 'id_capacidad';

    protected $fillable = ['memoria', 'ram'];

    public function modelos()
    {
        return $this->hasMany(Modelo::class, 'id_capacidad');
    }
}