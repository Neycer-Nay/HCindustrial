<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recepciones', function (Blueprint $table) {
            $table->id();
            $table->string('numero_recepcion');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('user_id') ->onDelete('set null'); // Usuario que registra
            $table->dateTime('fecha_ingreso')->useCurrent();
            $table->time('hora_ingreso')->useCurrent();
            
            $table->enum('estado', ['RECIBIDO', 'DIAGNOSTICADO', 'EN_REPARACION', 'REPARADO', 'ENTREGADO'])->default('RECIBIDO');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recepciones');
    }
};
