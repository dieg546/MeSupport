<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipoGarantiaResource;
use App\Models\AdjuntoGarantia;
use App\Models\Equipo;
use App\Models\SolicitudGarantia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class GarantiaController extends Controller
{
    // app/Http/Controllers/GarantiaController.php

    public function index(Request $request)
    {
        $equiposSinGarantia = $request->user()
            ->equipos()
            ->whereDoesntHave('solicitudesGarantia') // Filtra directamente en la BD
            ->with(['modelo.marca'])
            ->get();

        return Inertia::render('Garantias', [
            'devices' => EquipoGarantiaResource::collection($equiposSinGarantia)->resolve(),
        ]);
    }

    public function create(Request $request, $id)
    {
        $equipo = Equipo::with(['modelo.marca'])
            ->where('id_cliente', $request->user()->id)
            ->where('id_equipo', $id)
            ->firstOrFail();

        $fechaCompra = Carbon::parse($equipo->fecha_compra);

        return Inertia::render('SolicitudGarantia', [
            'device' => [
                'id'          => $equipo->id_equipo ?? $equipo->id,
                'name'        => trim(($equipo->modelo->marca->nombre_marca ?? '') . ' ' . ($equipo->modelo->nombre_modelo ?? '')),
                'capacity'    => ($equipo->modelo->ram ?? '8') . '/' . ($equipo->modelo->almacenamiento ?? '256'),
                'serial'      => $equipo->modelo->numero_serie,
                'imei'        => $equipo->imei,
                'fechaCompra' => $fechaCompra->format('d/m/Y'),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipo_id'         => 'required|exists:equipos,id_equipo',
            'descripcion_falla' => 'required|string|max:1000',
            'archivos'          => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $solicitud = SolicitudGarantia::create([
            'id_equipo'        => $validated['equipo_id'],
            'id_estado_actual' => 1,
            'descripcion_falla'=> $validated['descripcion_falla'],
        ]);

        if ($request->hasFile('archivos')) {
            $path = $request->file('archivos')->store('garantias/adjuntos', 'public');

            AdjuntoGarantia::create([
                'id_solicitud' => $solicitud->id_solicitud,
                'url_archivo'  => Storage::url($path),
            ]);
        }

        return redirect()->route('estado-garantias.index')
            ->with('success', 'Solicitud de garantía enviada correctamente.');
    }
}