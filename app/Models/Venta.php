<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $guarded = [];

    protected $casts = [
    'fecha' => 'date',
    'hora' => 'string',  // Agregar esto
    'cubicaje' => 'decimal:3',
];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function volqueta()
    {
        return $this->belongsTo(Volqueta::class);
    }
}