<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['PERSONA', 'EMPRESA']);
            $table->string('nombre');
            $table->enum('tipo_documento', ['CI', 'NIT', 'PASAPORTE', 'OTRO']);
            $table->string('numero_documento')->unique();
            $table->string('telefono_1');
            $table->string('telefono_2')->nullable();
            $table->string('telefono_3')->nullable();
            $table->string('email')->nullable();
            $table->string('ciudad')->default('Santa Cruz');
            $table->string('direccion');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};
