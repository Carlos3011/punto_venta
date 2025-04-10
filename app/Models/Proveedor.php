<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Proveedor extends Model
{
    protected static function booted()
    {
        static::deleted(function ($proveedor) {
            DB::statement('SET @num := 0');
            DB::statement('UPDATE proveedores SET id = @num := (@num + 1)');
            DB::statement('ALTER TABLE proveedores AUTO_INCREMENT = 1');
        });
    }

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