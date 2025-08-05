<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Trabajador; 
use Illuminate\Database\Eloquent\Model;

class SueldoHc extends Model
{
    use HasFactory;

    protected $table = 'sueldos';

    protected $fillable = [
        'trabajador_id', 'mes_pago', 'salario', 'descuento',
        'horas_extras', 'anticipo', 'total_liquido', 'fecha_pago'
    ];

    protected $casts = [
        'fecha_pago' => 'date',
        'salario' => 'decimal:2',
        'descuento' => 'decimal:2',
        'horas_extras' => 'decimal:2',
        'anticipo' => 'decimal:2',
        'total_liquido' => 'decimal:2',
    ];

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }
}
