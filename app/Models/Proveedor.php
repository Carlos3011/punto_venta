<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'contacto',
        'teléfono',
        'email'
    ];

    /**
     * Obtiene los productos asociados al proveedor
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_proveedor')
            ->withTimestamps();
    }
}