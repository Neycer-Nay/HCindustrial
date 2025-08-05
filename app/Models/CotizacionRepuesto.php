<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CotizacionRepuesto extends Model
{
     protected $fillable = [
        'cotizacion_equipo_id',
        'nombre',
        'cantidad',
        'precio_unitario'
    ];
    
    public function cotizacionEquipo()
    {
        return $this->belongsTo(CotizacionEquipo::class);
    }
    
    
    
    // Atributo calculado para subtotal
    public function getSubtotalAttribute()
    {
        return $this->cantidad * $this->precio_unitario;
    }

}
