<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    protected $table = 'egresos';

    protected $fillable = [
        'cuenta_id',
        'glosa',
        'razon_social',
        'nro_factura',
        'responsable',
        'metodo_pago',
        'subtotal',
        'descuento',
        'total',
        'estado_pago',
    ];
    protected $casts = [
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
    ];
    public function cuenta()
    {
        return $this->belongsTo(\App\Models\NombreCuenta::class, 'cuenta_id');
    }
}
