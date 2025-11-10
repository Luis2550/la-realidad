<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{

    protected $guarded = [];


    public function clientes(): BelongsToMany
    {
        return $this->belongsToMany(Cliente::class, 'cliente_material')
            ->withPivot('precio')
            ->withTimestamps();
    }


    public function preciosClientes()
    {
        return $this->hasMany(ClienteMaterial::class);
    }
}
