<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioInstalacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servicios_instalacion';

    protected $fillable = [
        'nombre',
        'tipo',
        'precio',
        'instalador_id'
    ];

    /**
     * Obtiene el instalador que ofrece este servicio
     */
    public function instalador()
    {
        return $this->belongsTo(Instalador::class);
    }

    /**
     * Scope para filtrar servicios por tipo
     */
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope para filtrar servicios por rango de precio
     */
    public function scopeRangoPrecio($query, $min, $max)
    {
        return $query->whereBetween('precio', [$min, $max]);
    }
}