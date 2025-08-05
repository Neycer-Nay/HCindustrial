<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SueldoHc; // Ensure you import the SueldoHc model
use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    use HasFactory;

    protected $table = 'trabajadores';
    protected $fillable = ['nombres', 'apellidos', 'cargo'];

    public function sueldos()
    {
        return $this->hasMany(SueldoHc::class);
    }
}
