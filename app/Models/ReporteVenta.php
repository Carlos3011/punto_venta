<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteVenta extends Model
{
    use HasFactory;

    protected $table = 'reportes_ventas';

    protected $fillable = [
        'fecha',
        'total_ventas',
        'total_descuentos',
        'ventas_efectivo',
        'ventas_tarjeta',
        'ventas_transferencia'
    ];

    protected $casts = [
        'fecha' => 'date'
    ];

    /**
     * Calcula el total neto de ventas
     */
    public function getTotalNetoAttribute()
    {
        return $this->total_ventas - $this->total_descuentos;
    }

    /**
     * Scope para filtrar por rango de fechas
     */
    public function scopeRangoFechas($query, $desde, $hasta)
    {
        return $query->whereBetween('fecha', [$desde, $hasta]);
    }

    /**
     * Scope para obtener reportes con ventas mayores a un monto
     */
    public function scopeVentasMayorA($query, $monto)
    {
        return $query->where('total_ventas', '>', $monto);
    }
}