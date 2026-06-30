<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Informe extends Model
{
     use HasFactory;

       protected $fillable = [
       'id_funcionario',
       'mes_pago',
       'valor_pagado',
       'pdf',
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'id_funcionario');
    }

    // Accesor para obtener la URL completa del PDF
    public function getPdfUrlAttribute()
    {
        if ($this->pdf_honorario) {
            return Storage::url($this->pdf_honorario);
        }
        return null;
    }

    // Accesor para obtener el nombre original del archivo
    public function getPdfNameAttribute()
    {
        if ($this->pdf_honorario) {
            return basename($this->pdf_honorario);
        }
        return null;
    }

    // Verificar si tiene PDF
    public function hasPdf()
    {
        return !is_null($this->pdf_honorario);
    }

}
