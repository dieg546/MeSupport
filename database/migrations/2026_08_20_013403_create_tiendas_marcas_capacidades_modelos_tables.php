<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiendas', function (Blueprint $table) {
            $table->id('id_tienda');
            $table->string('nombre_tienda', 100);
            $table->string('codigo_sucursal', 20)->unique()->nullable();
            $table->text('direccion')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('marcas', function (Blueprint $table) {
            $table->id('id_marca');
            $table->string('nombre_marca', 50)->unique();
            $table->timestamps();
        });

        Schema::create('capacidades', function (Blueprint $table) {
            $table->id('id_capacidad');
            $table->string('memoria', 20);
            $table->string('ram', 20);
            $table->timestamps();

            $table->unique(['memoria', 'ram']);
        });

        Schema::create('modelos', function (Blueprint $table) {
            $table->id('id_modelo');
            $table->foreignId('id_marca')->constrained('marcas', 'id_marca')->onDelete('cascade');
            $table->foreignId('id_capacidad')->constrained('capacidades', 'id_capacidad')->onDelete('cascade');
            $table->string('numero_serie', 50)->unique()->nullable();
            $table->string('nombre_modelo', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modelos');
        Schema::dropIfExists('capacidades');
        Schema::dropIfExists('marcas');
        Schema::dropIfExists('tiendas');
    }
};