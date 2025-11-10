<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClienteMaterial extends Model
{
    protected $table = 'cliente_material';
    
    protected $fillable = [
        'cliente_id',
        'material_id',
        'precio'
    ];

    protected $casts = [
        'precio' => 'decimal:2'
    ];

    // Relaciones
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}