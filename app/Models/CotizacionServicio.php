<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionServicio extends Model
{
    protected $fillable = [
        'cotizacion_equipo_id',
        'nombre',
        
    ];
    public function cotizacionEquipo()
    {
        return $this->belongsTo(CotizacionEquipo::class);
    }
}
