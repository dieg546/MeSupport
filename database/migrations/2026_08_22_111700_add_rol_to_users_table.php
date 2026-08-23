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
        Schema::table('users', function (Blueprint $table) {
            // Define 'cliente' como valor por defecto y 'admin' / 'tecnico' para administradores
            $table->string('rol', 20)->default('cliente');
        });
    }

    public function down(): void
    { 
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rol');
        });
    }
};
