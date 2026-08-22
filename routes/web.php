<?php

use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EstadoGarantiaController;
use App\Http\Controllers\GarantiaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirige directamente al login al entrar a la raíz
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard
Route::get('/dashboard', [EquipoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas Autenticadas
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
});

require __DIR__.'/auth.php';