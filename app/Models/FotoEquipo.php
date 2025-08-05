<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoEquipo extends Model
{
   protected $table = 'fotos_equipos';

    protected $fillable = [
        'equipo_id',
        'ruta',
        'descripcion'
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
    public function recepcion()
    {
        return $this->belongsTo(Recepcion::class);
    }

    

    // Nueva relación con cotizaciones (muchos a muchos)
    public function cotizacionEquipos()
    {
        return $this->belongsToMany(CotizacionEquipo::class, 'cotizacion_equipo_fotos')->withTimestamps();
    }
}
