<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CotizacionSerivicio;



class CotizacionEquipo extends Model
{
    protected $fillable = [
        'recepcion_id',
        'cotizacion_id',
        'equipo_id',
        'trabajo_realizar',
        'precio_trabajo',
        'repuestos',
        'total_repuestos',
        'fotos', // <-- agrega esto
        
    ];
    
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }
    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function repuestos()
    {
        return $this->hasMany(CotizacionRepuesto::class, 'cotizacion_equipo_id');
    }


    public function fotos()
    {
        return $this->belongsToMany(FotoEquipo::class, 'cotizacion_equipo_fotos', 'cotizacion_equipo_id', 'fotos_equipos_id');
    }

    public function servicios()
    {
        return $this->hasMany(CotizacionServicio::class, 'cotizacion_equipo_id');
    }

}
