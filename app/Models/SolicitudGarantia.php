<?php

namespace App\Models;

use App\Models\AdjuntoGarantia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SolicitudGarantia extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_garantias';
    protected $primaryKey = 'id_solicitud';

    protected $fillable = [
        'id_equipo',
        'id_estado_actual',
        'descripcion_falla',
    ];

    /**
     * Relación con el Equipo
     */
    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'id_equipo', 'id_equipo');
    }

    /**
     * Relación con el Estado de la Garantía
     */
    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoGarantia::class, 'id_estado_actual', 'id_estado');
    }

    /**
     * Relación con los Archivos Adjuntos
     */
    public function adjuntos(): HasMany
    {
        return $this->hasMany(AdjuntoGarantia::class, 'id_solicitud', 'id_solicitud');
    }
}