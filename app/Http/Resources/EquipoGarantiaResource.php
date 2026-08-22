<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipoGarantiaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $fechaCompra = Carbon::parse($this->fecha_compra);
        $fechaFin = $this->fecha_fin_garantia 
            ? Carbon::parse($this->fecha_fin_garantia) 
            : $fechaCompra->copy()->addYear();

        $hoy = Carbon::now();

        if ($hoy->greaterThan($fechaFin)) {
            $status = 'Vencida';
        } elseif ($hoy->diffInDays($fechaFin, false) <= 30) {
            $status = 'Por Vencer';
        } else {
            $status = 'Activa';
        }

        return [
            'id'          => $this->id_equipo ?? $this->id,
            'name'        => trim(($this->modelo->marca->nombre_marca ?? '') . ' ' . ($this->modelo->nombre_modelo ?? '')),
            'capacity'    => [
                'ram'     => $this->modelo->ram ?? '8GB',
                'memoria' => $this->modelo->almacenamiento ?? '256GB',
            ],
            'serial'      => $this->serial,
            'imei'        => $this->imei,
            'fechaCompra' => $fechaCompra->format('d/m/Y'),
            'endDate'     => $fechaFin->format('d/m/Y'),
            'status'      => $status,
        ];
    }
}