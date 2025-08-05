<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        // Tabla de trabajadores
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('cargo');
            $table->timestamps();
        });

        // Tabla de sueldos
        Schema::create('sueldos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trabajador_id')->constrained('trabajadores')->onDelete('cascade');
            $table->string('mes_pago');
            $table->decimal('salario', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('horas_extras', 10, 2)->default(0);
            $table->decimal('anticipo', 10, 2)->default(0);
            $table->decimal('total_liquido', 10, 2);
            $table->date('fecha_pago');
            $table->timestamps();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('sueldos');
        Schema::dropIfExists('trabajadores');
    }
};
