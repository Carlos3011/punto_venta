<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'teléfono',
        'rfc',
        'tipo_cliente'
    ];

    /**
     * Obtiene las ventas asociadas al cliente
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    /**
     * Obtiene las facturas del cliente a través de sus ventas
     */
    public function facturas()
    {
        return $this->hasManyThrough(Factura::class, Venta::class);
    }
}