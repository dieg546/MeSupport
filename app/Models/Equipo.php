<?php

namespace App\Models;

use App\Models\SolicitudGarantia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipos';
    protected $primaryKey = 'id_equipo';

    protected $fillable = [
        'id_cliente',
        'id_modelo',
        'id_tienda',
        'imei',
        'fecha_compra',
        'meses_garantia',
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'id_cliente');
    }

    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'id_modelo');
    }

    public function tienda()
    {
        return $this->belongsTo(Tienda::class, 'id_tienda');
    }

    // app/Models/Equipo.php

    public function solicitudesGarantia()
    {
        return $this->hasMany(SolicitudGarantia::class, 'id_equipo', 'id_equipo');
    }

}