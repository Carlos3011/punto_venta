<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'código',
        'descripción',
        'precio_mayoreo',
        'precio_menudeo',
        'estado',
        'categoria_id'
    ];

    /**
     * Obtiene la categoría a la que pertenece el producto
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * Obtiene los proveedores que suministran este producto
     */
    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class, 'producto_proveedor')
            ->withTimestamps();
    }

    /**
     * Obtiene los detalles de venta de este producto
     */
    public function ventaDetalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    /**
     * Obtiene los movimientos de stock de este producto
     */
    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Calcula el stock actual del producto
     */
    public function getStockActualAttribute()
    {
        return $this->stock()->sum('cantidad');
    }
}