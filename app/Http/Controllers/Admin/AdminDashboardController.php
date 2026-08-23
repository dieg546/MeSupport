<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\SolicitudGarantia;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Capacidad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/AdminDashboard', [
            'stats' => [
                'totalProductos'      => Equipo::count(),
                'crecimiento'         => '20%',
                'garantiasActivas'    => SolicitudGarantia::where('id_estado_actual', 1)->count(), // Abierta / Pendiente
                'garantiasEnRevision' => SolicitudGarantia::where('id_estado_actual', 2)->count(), // En Revisión
            ],
            'ultimasSolicitudes' => SolicitudGarantia::with(['equipo.modelo.marca', 'estadoActual'])
                ->latest()
                ->take(3)
                ->get()
                ->map(fn($sol) => [
                    'id'     => $sol->id_solicitud,
                    'ticket' => 'Ticket-2024-' . $sol->id_solicitud,
                    'falla'  => $sol->descripcion_falla,
                    'modelo' => trim(($sol->equipo->modelo->marca->nombre_marca ?? '') . ' ' . ($sol->equipo->modelo->nombre_modelo ?? '') . ' ' . ($sol->equipo->modelo->ram ?? '') . ($sol->equipo->modelo->almacenamiento ?? '')),
                    'capacidad' => trim(($sol->equipo->modelo->capacidad->ram ?? '') . ' / ' . ($sol->equipo->modelo->capacidad->memoria ?? '')),
                    'estado' => $sol->estadoActual->nombre_estado ?? 'Abierta',
                ]),
        ]);
    }


    public function show($id)
    {
        $solicitud = SolicitudGarantia::with([
            'equipo.modelo.marca',
            'equipo.modelo.capacidad',
            'equipo.cliente',
            'estadoActual', // Carga de la relación con el estado actual
            'adjuntos'
        ])->findOrFail($id);

        $equipo = $solicitud->equipo;
        $cliente = $equipo?->cliente;

        // Formatear cliente
        $nombreCliente = $cliente 
            ? trim(($cliente->name ?? $cliente->nombre ?? '') . ' ' . ($cliente->apellido ?? '')) 
            : 'N/A';

        // Formatear fechas
        $fechaCompra = $equipo?->fecha_compra 
            ? \Carbon\Carbon::parse($equipo->fecha_compra)->format('d/m/Y') 
            : 'N/A';

        $fechaFinGarantia = ($equipo?->fecha_compra && $equipo?->meses_garantia)
            ? \Carbon\Carbon::parse($equipo->fecha_compra)->addMonths((int)$equipo->meses_garantia)->format('d/m/Y')
            : 'N/A';

        // Obtener el primer registro de adjuntos
        $primerAdjunto = $solicitud->adjuntos->first();

        // Generar la URL absoluta a partir de url_archivo
        $evidenciasUrl = $primerAdjunto?->url_archivo 
            ? asset(ltrim($primerAdjunto->url_archivo, '/')) 
            : null;

        return Inertia::render('Admin/GestionSolicitud', [
            'solicitud' => [
                'id'                 => $solicitud->id_solicitud,
                'cliente'            => $nombreCliente,
                'dispositivo'        => trim(($equipo?->modelo?->marca?->nombre_marca ?? '') . ' ' . ($equipo?->modelo?->nombre_modelo ?? '')),
                'capacidad'          => trim(($equipo?->modelo?->capacidad?->ram ?? '') . '/' . ($equipo?->modelo?->capacidad?->memoria ?? '')),
                'serial'             => $equipo?->modelo?->numero_serie ?? 'N/A',
                'imei'               => $equipo?->imei ?? 'N/A',
                'falla'              => $solicitud->descripcion_falla,
                'fecha_compra'       => $fechaCompra,
                'fecha_fin_garantia' => $fechaFinGarantia,
                'evidencias_url'     => $evidenciasUrl,
                
                // Atributos del estado necesarios para la vista en Vue
                'estado_id'          => $solicitud->id_estado_actual,
                'estado'             => $solicitud->estadoActual?->nombre_estado ?? 'Abierta',
                'observacion'        => $solicitud->observaciones ?? null,
            ]
        ]);
    }

    
    public function store(Request $request)
    {
        // 1. Validar los datos recibidos del formulario
        $validated = $request->validate([
            'nombre_marca'   => 'required|string|max:50',
            'nombre_modelo'  => 'required|string|max:50',
            'almacenamiento' => 'required|string|max:20',
            'ram'            => 'required|string|max:20',
            'serial'         => 'required|string|max:50|unique:modelos,numero_serie',
        ]);

        // 2. Buscar o crear la Marca
        $marca = Marca::firstOrCreate([
            'nombre_marca' => trim($validated['nombre_marca']),
        ]);

        // 3. Buscar o crear la Capacidad (evalúa el par único memoria/ram)
        $capacidad = Capacidad::firstOrCreate([
            'memoria' => trim($validated['almacenamiento']) . ' GB',
            'ram'     => trim($validated['ram']) . ' GB',
        ]);

        // 4. Crear el Modelo relacionado
        Modelo::create([
            'id_marca'     => $marca->id_marca,
            'id_capacidad' => $capacidad->id_capacidad,
            'nombre_modelo' => trim($validated['nombre_modelo']),
            'numero_serie'  => trim($validated['serial']),
        ]);

        return redirect()->back()->with('success', 'Producto registrado correctamente.');
    }

}