<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recepcion_id')->constrained('recepciones');
            $table->date('fecha')->useCurrent();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->timestamps();
        });

        
        Schema::create('cotizacion_equipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')->constrained('cotizaciones')->onDelete('cascade');
            $table->foreignId('equipo_id')->constrained('equipos');
            $table->text('trabajo_realizar')->nullable();
            $table->decimal('precio_trabajo', 12, 2)->default(0);
            $table->decimal('total_repuestos', 12, 2)->default(0);
            $table->timestamps();
        });

        // Tabla para repuestos
        Schema::create('cotizacion_repuestos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_equipo_id')->constrained('cotizacion_equipos')->onDelete('cascade');
            $table->string('nombre');
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_unitario', 12, 2);
            $table->decimal('subtotal', 12, 2)->virtualAs('cantidad * precio_unitario');
            $table->timestamps();
        });

        // Tabla para serivios realizados
        Schema::create('cotizacion_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_equipo_id')->constrained('cotizacion_equipos')->onDelete('cascade');
            $table->string('nombre');
            $table->timestamps();
        });
        

        
        Schema::create('cotizacion_equipo_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_equipo_id')->constrained('cotizacion_equipos')->onDelete('cascade');
            $table->foreignId('fotos_equipos_id')->constrained('fotos_equipos')->onDelete('cascade');
            $table->timestamps();

            // Evita duplicados
            $table->unique(['cotizacion_equipo_id', 'fotos_equipos_id'],'cot_eq_foto_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacion_equipos');
        Schema::dropIfExists('cotizaciones');
        Schema::dropIfExists('cotizacion_repuestos');
        Schema::dropIfExists('cotizacion_equipo_fotos');
    }
};
