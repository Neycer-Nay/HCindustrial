<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabla nombre_cuentas
        Schema::create('nombre_cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cuenta');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        // Tabla egresos
        Schema::create('egresos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuenta_id')->constrained('nombre_cuentas')->onDelete('cascade');
            $table->string('glosa');
            $table->string('razon_social');
            $table->string('nro_factura');
            $table->string('responsable'); 
            $table->string('metodo_pago');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('descuento', 15, 2)->default(0);
            $table->decimal('total', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('egresos');
        Schema::dropIfExists('nombre_cuentas');
    }
};
