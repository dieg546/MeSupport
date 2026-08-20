<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Tienda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::with(['modelo.marca', 'tienda'])
            ->where('id_cliente', auth()->id())
            ->latest()
            ->get()
            ->map(function ($equipo) {
                $fechaCompra = Carbon::parse($equipo->fecha_compra);
                $meses = $equipo->meses_garantia ?? 12;
                $fechaFinGarantia = $fechaCompra->copy()->addMonths($meses);
                $diasRestantes = (int) now()->diffInDays($fechaFinGarantia, false);

                // Cálculo del estado según la fecha de garantía
                if ($diasRestantes < 0) {
                    $status = 'Vencida';
                } elseif ($diasRestantes <= 30) {
                    $status = 'Por Vencer';
                } else {
                    $status = 'Activa';
                }

                return [
                    'id'          => $equipo->id_equipo ?? $equipo->id,
                    'name'        => trim(($equipo->modelo->marca->nombre_marca ?? '') . ' ' . ($equipo->modelo->nombre_modelo ?? '')),
                    'capacity'    => $equipo->modelo->capacidad ?? 'N/A',
                    'serial'      => $equipo->modelo->numero_serie,
                    'imei'        => $equipo->imei,
                    'fechaCompra' => Carbon::parse($equipo->fecha_compra)->format('d/m/Y'),
                    'endDate'     => $fechaFinGarantia->format('d/m/Y'),
                    'status'      => $status,
                ];
            });

        return Inertia::render('Dashboard', [
            'marcas'  => Marca::select('id_marca', 'nombre_marca')->get(),
            'modelos' => Modelo::select('id_modelo', 'id_marca', 'nombre_modelo')->get(),
            'tiendas' => Tienda::select('id_tienda', 'nombre_tienda')->get(),
            'devices' => $equipos, // Nombre alineado con defineProps({ devices: ... })
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_modelo'     => 'required|exists:modelos,id_modelo',
            'id_tienda'     => 'required|exists:tiendas,id_tienda',
            'imei_equipo'   => 'nullable|string|max:50',
            'fecha_compra'  => 'required|date',
        ]);

        Equipo::create([
            'id_cliente'     => auth()->id(),
            'id_modelo'      => $validated['id_modelo'],
            'id_tienda'      => $validated['id_tienda'],
            'imei'           => $validated['imei_equipo'],
            'fecha_compra'   => $validated['fecha_compra'],
            'meses_garantia' => 12,
        ]);

        return redirect()->back();
    }
}