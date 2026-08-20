<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id('id_equipo');
            $table->foreignId('id_cliente')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('id_modelo')->constrained('modelos', 'id_modelo')->onDelete('cascade');
            $table->foreignId('id_tienda')->constrained('tiendas', 'id_tienda')->onDelete('cascade');
            $table->string('imei', 50)->nullable();
            $table->date('fecha_compra');
            $table->integer('meses_garantia')->default(12);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};