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
       Schema::create('ingresos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_ingreso');
            $table->string('glosa');
            $table->string('razon_social');
            $table->string('nro_recibo');
            $table->string('metodo_pago');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('descuento', 15, 2)->default(0);
            $table->decimal('total', 15, 2);
            $table->string('estado_pago');
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingresos');
    }
};
