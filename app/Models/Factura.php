<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'rfc_cliente',
        'uuid',
        'xml',
        'pdf'
    ];

    /**
     * Obtiene la venta asociada a esta factura
     */
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    /**
     * Obtiene el cliente a través de la venta
     */
    public function cliente()
    {
        return $this->hasOneThrough(Cliente::class, Venta::class);
    }
}