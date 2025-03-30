<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'cliente_id',
        'fecha',
        'total',
        'forma_pago',
        'descuento'
    ];

    protected $casts = [
        'fecha' => 'date'
    ];

    /**
     * Obtiene el usuario que realizó la venta
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtiene el cliente asociado a la venta
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Obtiene los detalles de la venta
     */
    public function detalles()
    {
        return $this->hasMany(VentaDetalle::class);
    }

    /**
     * Obtiene la factura asociada a la venta
     */
    public function factura()
    {
        return $this->hasOne(Factura::class);
    }

    /**
     * Obtiene el ticket asociado a la venta
     */
    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }

    /**
     * Calcula el total neto de la venta
     */
    public function getTotalNetoAttribute()
    {
        return $this->total - $this->descuento;
    }
}