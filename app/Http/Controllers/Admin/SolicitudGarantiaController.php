<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SolicitudGarantia;
use App\Models\EstadoGarantia;
use App\Models\HistorialEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SolicitudGarantiaController extends Controller
{
    public function cambiarEstado(Request $request, $id)
    {
        $request->validate([
            'estado_id'   => 'required|integer|exists:estados_garantias,id_estado',
            'observacion' => 'required|string|max:1000',
        ]);

        DB::transaction(function () use ($request, $id) {
            $solicitud = SolicitudGarantia::findOrFail($id);

            // 1. Actualizar estado actual de la solicitud
            $solicitud->update([
                'id_estado_actual' => $request->estado_id,
            ]);

            // 2. Registrar traza en la tabla historial_estados
            HistorialEstado::create([
                'id_solicitud'  => $solicitud->id_solicitud,
                'id_estado'     => $request->estado_id,
                'fecha_cambio'  => now(),
                'observaciones' => $request->observacion,
            ]);
        });

        // Redirigir al menú principal / dashboard del admin
        return redirect()->route('admin.dashboard')->with('success', 'La solicitud ha sido procesada exitosamente.');
    }

    public function enRevision(Request $request)
    {
        // Definimos los IDs de los estados que NO queremos mostrar (ej. 1: Solicitado/Pendiente, 4: Rechazada)
        $estadosExcluidos = [1, 4];

        // Cargamos en 'with' las relaciones anidadas para cliente y modelo
        $query = SolicitudGarantia::with([
            'equipo.cliente', 
            'equipo.modelo', 
            'estadoActual'
        ])->whereNotIn('id_estado_actual', $estadosExcluidos);

        // 1. Filtrar por Estado (Si viene en el request y no es 'todos')
        if ($request->filled('estado') && $request->estado !== 'todos') {
            $query->where('id_estado_actual', $request->estado);
        }

        // 2. Búsqueda en tiempo real (por ID, cliente o modelo)
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('id_solicitud', 'like', "%{$buscar}%")
                ->orWhereHas('equipo.cliente', function($qCliente) use ($buscar) {
                    $qCliente->where('name', 'like', "%{$buscar}%");
                })
                ->orWhereHas('equipo.modelo', function($qModelo) use ($buscar) {
                    $qModelo->where('nombre_modelo', 'like', "%{$buscar}%");
                });
            });
        }

        $solicitudes = $query->latest('id_solicitud')->get()->map(function ($item) {
            return [
                'id'               => $item->id_solicitud,
                'id_solicitud'     => $item->id_solicitud,
                'id_estado_actual' => $item->id_estado_actual,
                'cliente'          => $item->equipo->cliente->name 
                                        ?? $item->equipo->cliente->nombre 
                                        ?? 'Cliente sin nombre',
                'ticket'           => 'Ticket-2024-' . $item->id_solicitud,
                'falla'            => $item->descripcion_falla ?? 'Sin descripción',
                'dispositivo'      => $item->equipo->modelo->nombre_modelo 
                                        ?? $item->equipo->nombre 
                                        ?? 'Dispositivo',
                'estado'           => $item->estadoActual->nombre_estado ?? 'En Revisión',
                'fecha'            => $item->created_at ? $item->created_at->format('d/m/Y') : 'Sin fecha',
            ];
        });

        $estados = \App\Models\EstadoGarantia::whereNotIn('id_estado', $estadosExcluidos)->get();

        return Inertia::render('Admin/ProductoEnGarantia', [
            'solicitudes' => $solicitudes,
            'estados'     => $estados,
            // Agregamos 'estado' en la respuesta de los filtros
            'filters'     => $request->only(['buscar', 'estado']) 
        ]);
    }

    public function gestion($id)
    {
        $solicitud = SolicitudGarantia::with(['equipo', 'estadoActual'])->findOrFail($id);
        $estados = EstadoGarantia::all();

        return Inertia::render('Admin/GestionSolicitud', [
            'solicitud' => [
                'id_solicitud'      => $solicitud->id_solicitud,
                'id_estado_actual' => $solicitud->id_estado_actual,
                'cliente'           => $solicitud->cliente ?? 'Cliente',
                'dispositivo'       => $solicitud->equipo->nombre ?? 'N/A',
                'falla'             => $solicitud->descripcion_falla ?? 'Sin descripción',
                'fecha_compra'      => $solicitud->fecha_compra ?? 'N/A',
                'fecha_fin_garantia'=> $solicitud->fecha_fin_garantia ?? 'N/A',
                'evidencias_url'    => $solicitud->evidencias_url ?? null,
            ],
            'estados' => $estados
        ]);
    }

    public function solicitudes(Request $request)
    {
        $query = SolicitudGarantia::with(['equipo.modelo', 'equipo.cliente', 'estadoActual']);

        // Filtrar por estado si el usuario selecciona uno en el dropdown
        if ($request->filled('estado') && $request->estado !== 'todos') {
            $query->where('id_estado_actual', $request->estado);
        }

        $solicitudes = $query->latest('id_solicitud')->get()->map(function ($solicitud) {
            return [
                'id'          => $solicitud->id_solicitud,
                'dispositivo' => $solicitud->equipo->modelo->nombre_modelo ?? $solicitud->equipo->nombre ?? 'Dispositivo',
                'capacidad'   => ($solicitud->equipo->ram ?? '8') . '/' . ($solicitud->equipo->almacenamiento ?? '256'),
                'fecha'       => $solicitud->created_at ? $solicitud->created_at->format('d/m/Y') : 'N/A',
                'estado'      => $solicitud->estadoActual->nombre_estado ?? 'Sin Estado',
            ];
        });

        // Cargamos todos los estados de la base de datos para el <select>
        $estados = EstadoGarantia::all();

        return Inertia::render('Admin/SolicitudesActivas', [
            'solicitudes' => $solicitudes,
            'estados'     => $estados,
            'filters'     => $request->only(['estado'])
        ]);
    }

}