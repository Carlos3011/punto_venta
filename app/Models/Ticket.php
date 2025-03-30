<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'ticket_text',
        'fecha_generacion'
    ];

    protected $casts = [
        'fecha_generacion' => 'date'
    ];

    /**
     * Obtiene la venta asociada a este ticket
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