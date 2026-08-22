<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoGarantia extends Model
{
    use HasFactory;

    // Nombre exacto de la tabla en tu base de datos
    protected $table = 'estados_garantias';

    // Clave primaria personalizada
    protected $primaryKey = 'id_estado';

    protected $fillable = [
        'nombre_estado',
    ];

    /**
     * Relación con las solicitudes de garantía
     */
    public function solicitudes(): HasMany
    {
        return $this->hasMany(SolicitudGarantia::class, 'id_estado_actual', 'id_estado');
    }
}