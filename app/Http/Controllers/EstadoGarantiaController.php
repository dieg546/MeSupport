<?php

namespace App\Http\Controllers;

use App\Models\EstadoGarantia;
use App\Models\SolicitudGarantia;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EstadoGarantiaController extends Controller
{
    public function index(Request $request)
    {
        $estadoFiltro = $request->query('estado');

        $solicitudesQuery = SolicitudGarantia::with(['equipo.modelo.marca', 'estado'])
            ->whereHas('equipo', function ($query) use ($request) {
                $query->where('id_cliente', $request->user()->id);
            });

        if ($estadoFiltro) {
            $solicitudesQuery->where('id_estado_actual', $estadoFiltro);
        }

        $solicitudes = $solicitudesQuery->get()->map(function ($solicitud) {
            return [
                'id'            => $solicitud->id_solicitud,
                'ticket'        => 'Ticket-2024-' . $solicitud->id_solicitud,
                'falla'         => $solicitud->descripcion_falla,
                'equipo'        => trim(($solicitud->equipo->modelo->marca->nombre_marca ?? '') . ' ' . ($solicitud->equipo->modelo->nombre_modelo ?? '')),
                'capacidad'     => ($solicitud->equipo->modelo->ram ?? '8') . '/' . ($solicitud->equipo->modelo->almacenamiento ?? '256'),
                'estado_id'     => $solicitud->id_estado_actual,
                'estado_nombre' => $solicitud->estado->nombre_estado ?? 'Abierta',
            ];
        });

        return Inertia::render('EstadoGarantia', [
            'cliente'     => $request->user()->name,
            'solicitudes' => $solicitudes,
            'estados'     => EstadoGarantia::all(),
            'filtro'      => $estadoFiltro ?? '',
        ]);
    }
}