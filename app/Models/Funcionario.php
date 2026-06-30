<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Funcionario extends Model
{
    use HasFactory;

       protected $fillable = [
        'rut',
        'nombre',
        'fecha_ingreso',
        'fecha_termino',
    ];

    public function informes()
    {
        return $this->hasMany(Informe::class, 'id_funcionario');
    }

}
