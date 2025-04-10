<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categoria extends Model
{
    protected static function booted()
    {
        static::deleted(function ($categoria) {
            DB::statement('SET @num := 0');
            DB::statement('UPDATE categorias SET id = @num := (@num + 1)');
            DB::statement('ALTER TABLE categorias AUTO_INCREMENT = 1');
        });
    }
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