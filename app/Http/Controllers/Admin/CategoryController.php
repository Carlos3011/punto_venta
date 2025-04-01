<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Categoria::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('nombre', 'LIKE', "%{$searchTerm}%");
        }

        if ($request->has('order_by')) {
            $direction = $request->direction == 'asc' ? 'asc' : 'desc';
            $query->orderBy($request->order_by, $direction);
        }

        $perPage = $request->per_page ?? 10;
        $categorias = $query->paginate($perPage);
        return view('admin.category.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias'
        ]);

        Categoria::create($request->all());

        return redirect()->route('admin.category.index')
            ->with('success', 'Categoría creada exitosamente');
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.category.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categorias,nombre,' . $categoria->id
        ]);

        $categoria->update($request->all());

        return redirect()->route('admin.category.index')
            ->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy(Categoria $categoria)
    {
        // Verificar relación con productos antes de eliminar
        if ($categoria->productos()->exists()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar la categoría porque tiene productos asociados');
        }

        $categoria->delete();

        return redirect()->route('admin.category.index')
            ->with('success', 'Categoría eliminada correctamente');
    }
}
