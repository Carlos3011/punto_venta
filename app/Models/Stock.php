<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    protected static function booted()
    {
        static::deleted(function ($stock) {
            DB::statement('SET @num := 0');
            DB::statement('UPDATE stock SET id = @num := (@num + 1)');
            DB::statement('ALTER TABLE stock AUTO_INCREMENT = 1');
        });
    }

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