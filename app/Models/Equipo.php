<?php

namespace App\Models;

use Illuminate\Cache\Events\ForgettingKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $recepcion_id
 * @property int $cliente_id
 * @property string $nombre
 * @property string $tipo
 * @property string $marca
 * @property string $modelo
 * @property string $color
 * @property string $numero_serie
 * @property float $potencia
 * @property float $voltaje
 * @property float $hp
 * @property float $rpm
 * @property float $hz
 * @property float $amperaje
 * @property string $cable_positivo
 * @property string $cable_negativo
 * @property float $kva_kw
 * @property string|null $partes_faltantes
 * @property string|null $observaciones
 * @property int $id
 */

class Equipo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'recepcion_id',
        'cliente_id',
        'nombre',
        'tipo',
        'marca',
        'modelo',
        'color',
        'numero_serie',
        'potencia',
        'voltaje',
        'hp',
        'rpm',
        'hz',
        'amperaje',
        'cable_positivo',
        'cable_negativo',
        'kva_kw',
        'partes_faltantes',
        'observaciones',
    ];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Relación con Recepción
    public function recepcion()
    {
        return $this->belongsTo(Recepcion::class);
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(FotoEquipo::class, 'equipo_id');
    }

    
}
