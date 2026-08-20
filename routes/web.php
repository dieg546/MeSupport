<?php

use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirige directamente al login al entrar a la raíz
Route::get('/', function () {
    return redirect()->route('login');
});

// ✅ CORREGIDO: Apunta al método index de EquipoController
Route::get('/dashboard', [EquipoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/equipos', [EquipoController::class, 'store'])->name('equipos.store');
});

require __DIR__.'/auth.php';