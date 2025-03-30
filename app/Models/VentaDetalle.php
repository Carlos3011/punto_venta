<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    use HasFactory;

    protected $table = 'venta_detalle';

    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    /**
     * Obtiene la venta a la que pertenece este detalle
     */
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    /**
     * Obtiene el producto vendido
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Calcula el subtotal del detalle
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($detalle) {
            $detalle->subtotal = $detalle->cantidad * $detalle->precio_unitario;
        });
    }
}