<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SolicitudGarantiaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EstadoGarantiaController;
use App\Http\Controllers\GarantiaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirige directamente al login al entrar a la raíz
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard inteligente: redirige según el rol del usuario
Route::get('/dashboard', function () {
    if (auth()->user()->rol === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return app(EquipoController::class)->index();
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas Autenticadas (Cliente y Comunes)
Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Equipos
    Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');

    // Garantías
    Route::get('/garantias', [GarantiaController::class, 'index'])->name('garantias.index');
    Route::get('/garantias/crear/{id}', [GarantiaController::class, 'create'])->name('garantias.create');
    Route::post('/garantias', [GarantiaController::class, 'store'])->name('garantias.store');

    // Estado de Garantías
    Route::get('/estado-garantias', [EstadoGarantiaController::class, 'index'])->name('estado-garantias.index');
    Route::get('/estado-garantias/{id}', [EstadoGarantiaController::class, 'show'])->name('estado-garantias.show');
});

// Ruta protegida únicamente para Administradores
// Ruta protegida únicamente para Administradores
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Genera URL: /admin/dashboard | Nombre: admin.dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Genera URL: /admin/equipos | Nombre: admin.dashboard.equipos.store
    Route::post('/equipos', [AdminDashboardController::class, 'store'])->name('dashboard.equipos.store');

    Route::get('/solicitudes/{id}', [AdminDashboardController::class, 'show'])->name('solicitudes.show');

    Route::patch('/garantias/{id}/estado', [SolicitudGarantiaController::class, 'cambiarEstado'])
    ->name('garantias.actualizar-estado');

    Route::get('/garantias/en-revision', [SolicitudGarantiaController::class, 'enRevision'])
    ->name('garantias.en-revision');

    Route::get('/garantias/{id}/gestion', [SolicitudGarantiaController::class, 'gestion'])
    ->name('garantias.gestion');

    Route::get('/solicitudes', [SolicitudGarantiaController::class, 'solicitudes'])
        ->name('solicitudes.index');
});

require __DIR__.'/auth.php';