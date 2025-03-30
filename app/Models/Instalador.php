<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instalador extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'instaladores';

    protected $fillable = [
        'nombre',
        'teléfono',
        'especialidad'
    ];

    /**
     * Obtiene los servicios de instalación que ofrece este instalador
     */
    public function servicios()
    {
        return $this->hasMany(ServicioInstalacion::class);
    }

    /**
     * Verifica si el instalador tiene servicios activos
     */
    public function tieneServiciosActivos()
    {
        return $this->servicios()->count() > 0;
    }
}