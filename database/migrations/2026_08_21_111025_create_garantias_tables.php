<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabla Estados_Garantia
        Schema::create('estados_garantias', function (Blueprint $table) {
            $table->id('id_estado');
            $table->string('nombre_estado', 50);
            $table->timestamps();
        });

        // 2. Tabla Solicitudes_Garantia
        Schema::create('solicitudes_garantias', function (Blueprint $table) {
            $table->id('id_solicitud');
            $table->unsignedBigInteger('id_equipo');
            $table->unsignedBigInteger('id_estado_actual');
            $table->timestamp('fecha_solicitud')->useCurrent();
            $table->text('descripcion_falla');
            $table->timestamps();

            // Claves foráneas (Ajusta 'equipos' e 'id_equipo' si tu tabla de equipos usa otro nombre)
            $table->foreign('id_equipo')
                  ->references('id_equipo')
                  ->on('equipos')
                  ->onDelete('cascade');

            $table->foreign('id_estado_actual')
                  ->references('id_estado')
                  ->on('estados_garantias')
                  ->onDelete('restrict');
        });

        // 3. Tabla Adjuntos_Garantia
        Schema::create('adjuntos_garantias', function (Blueprint $table) {
            $table->id('id_adjunto');
            $table->unsignedBigInteger('id_solicitud');
            $table->string('url_archivo', 255);
            $table->timestamps();

            // Clave foránea
            $table->foreign('id_solicitud')
                  ->references('id_solicitud')
                  ->on('solicitudes_garantias')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjuntos_garantias');
        Schema::dropIfExists('solicitudes_garantias');
        Schema::dropIfExists('estados_garantias');
    }
};