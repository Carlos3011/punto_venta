<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $products = Producto::with(['categoria', 'proveedores'])
        ->select('id', 'nombre', 'código', 'descripción', 'stock', 'precio_mayoreo', 'precio_menudeo', 'estado', 'categoria_id')
        ->when($request->search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                  ->orWhere('código', 'like', "%$search%");
            });
        })
        ->when($request->categoria_id, function ($query, $categoria_id) {
            $query->where('categoria_id', $categoria_id);
        })
        ->when($request->order_by && $request->direction, function ($query) use ($request) {
            $query->orderBy($request->order_by, $request->direction);
        })
        ->paginate($request->per_page ?? 10);

    $categorias = Categoria::all();

    return view('admin.products.index', compact('products', 'categorias'));
}

    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.products.create', compact('categorias'));
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('admin.products.edit', compact('producto', 'categorias'));
    }

    public function destroy(Producto $producto)
    {
        try {
            $producto->delete();
            return response()->json([
                'success' => true,
                'message' => 'Producto eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el producto: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Producto $producto): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'código' => ['required', 'string', 'max:50'],
            'descripción' => ['required', 'string'],
            'stock' => ['required', 'numeric', 'min:0'],
            'precio_mayoreo' => ['required', 'numeric', 'min:0'],
            'precio_menudeo' => ['required', 'numeric', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'estado' => ['boolean']
        ]);

        $productoData = [
            'nombre' => $request->nombre,
            'código' => $request->código,
            'descripción' => $request->descripción,
            'stock' => $request->stock,
            'precio_mayoreo' => $request->precio_mayoreo,
            'precio_menudeo' => $request->precio_menudeo,
            'categoria_id' => $request->categoria_id,
            'estado' => $request->has('estado')
        ];

        try {
            $producto->update($productoData);

            return redirect()->route('admin.products.index')
                ->with('success', 'Producto actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el producto: ' . $e->getMessage());
        }
    }
}
