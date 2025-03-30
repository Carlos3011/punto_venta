<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caja extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'usuario_id',
        'fecha',
        'monto_inicial',
        'total_ventas',
        'total_efectivo',
        'total_tarjeta',
        'total_transferencia',
        'total_gastos',
        'diferencia_caja'
    ];

    protected $casts = [
        'fecha' => 'date'
    ];

    /**
     * Obtiene el usuario responsable de la caja
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Calcula el balance final de la caja
     */
    public function getBalanceFinalAttribute()
    {
        return $this->monto_inicial + $this->total_ventas - $this->total_gastos;
    }

    /**
     * Verifica si hay diferencia en caja
     */
    public function hayDiferencia()
    {
        return $this->diferencia_caja != 0;
    }

    /**
     * Scope para filtrar por fecha
     */
    public function scopeFecha($query, $fecha)
    {
        return $query->whereDate('fecha', $fecha);
    }
}