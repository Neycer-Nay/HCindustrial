<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table = 'ingresos';

    protected $fillable = [
        'tipo_ingreso',
        'glosa',
        'razon_social',
        'nro_recibo',
        'metodo_pago',
        'subtotal',
        'descuento',
        'total',
        'estado_pago'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2'
    ];
}
