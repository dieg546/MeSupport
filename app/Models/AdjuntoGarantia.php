<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdjuntoGarantia extends Model
{
    protected $table = 'adjuntos_garantias';
    protected $primaryKey = 'id_adjunto';

    protected $fillable = [
        'id_solicitud',
        'url_archivo',
    ];
}