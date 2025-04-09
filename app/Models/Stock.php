<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $table = 'stock';

    protected $fillable = [
        'producto_id',
        'fecha_movimiento',
        'tipo_movimiento',
        'cantidad',
        'observaciones'
    ];

    protected $casts = [
        'fecha_movimiento' => 'datetime',
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}