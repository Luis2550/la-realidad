<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volqueta extends Model
{
    
    protected $guarded = [];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
