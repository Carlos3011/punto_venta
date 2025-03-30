<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre'
    ];

    /**
     * Obtiene los productos que pertenecen a esta categoría
     */
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}