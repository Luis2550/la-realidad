<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cliente extends Model
{

  protected $guarded = [];


  public function ventas()
  {
    return $this->hasMany(Venta::class);
  }


  public function materials(): BelongsToMany
  {
    return $this->belongsToMany(Material::class, 'cliente_material')
      ->withPivot('precio')
      ->withTimestamps();
  }


  public function preciosMateriales()
  {
    return $this->hasMany(ClienteMaterial::class);
  }
}
