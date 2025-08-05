<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NombreCuenta extends Model
{
    protected $table = 'nombre_cuentas';

    protected $fillable = [
        'nombre_cuenta',
        'descripcion',
    ];

    public function egresos()
    {
        return $this->hasMany(Egreso::class, 'cuenta_id');
    }


}
