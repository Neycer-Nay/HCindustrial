<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $numero_recepcion
 * @property int $cliente_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $fecha_ingreso
 * @property \Illuminate\Support\Carbon $hora_ingreso
 * @property string $estado
 * @property int $id
 */


class Recepcion extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'recepciones';

    protected $fillable = [
        'numero_recepcion',
        'cliente_id',
        'user_id',
        'fecha_ingreso',
        'hora_ingreso',       
        'estado'
    ];

    protected $casts = [
        'fecha_ingreso' => 'datetime',
        'hora_ingreso',  
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con Usuario (encargado)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con Equipos
    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function FotoEquipo()
    {
        return $this->belongsTo(FotoEquipo::class);
    }

    public function cotizacion()
    {
        return $this->hasOne(Cotizacion::class);
    }

}
