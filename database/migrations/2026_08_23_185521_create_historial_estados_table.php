<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial_estados', function (Blueprint $table) {
            $table->id('id_historial');
            
            // Claves foráneas (Asegúrate de ajustar los nombres de tabla si difieren)
            $table->foreignId('id_solicitud')
                  ->constrained('solicitudes_garantias', 'id_solicitud')
                  ->onDelete('cascade');

            $table->foreignId('id_estado') 
                  ->constrained('estados_garantias', 'id_estado')
                  ->onDelete('cascade');

            $table->timestamp('fecha_cambio')->useCurrent();
            $table->text('observaciones')->nullable();

            // Deshabilitar timestamps por defecto si solo se usa fecha_cambio
            // $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial_estados');
    }
};