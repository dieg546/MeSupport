<?php

namespace App\Models;

use App\Models\EstadoGarantia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialEstado extends Model
{
    use HasFactory;

    protected $table = 'historial_estados';
    protected $primaryKey = 'id_historial';
    public $timestamps = false; // Usa fecha_cambio en lugar de created_at/updated_at

    protected $fillable = [
        'id_solicitud',
        'id_estado',
        'fecha_cambio',
        'observaciones',
    ];

    protected $casts = [
        'fecha_cambio' => 'datetime',
    ];

    public function solicitud()
    {
        return $this->belongsTo(SolicitudGarantia::class, 'id_solicitud', 'id_solicitud');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoGarantia::class, 'id_estado', 'id_estado');
    }
}