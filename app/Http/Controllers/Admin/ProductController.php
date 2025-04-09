<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $products = Producto::with(['categoria', 'proveedores'])
        ->select('id', 'nombre', 'código', 'descripción', 'precio_mayoreo', 'precio_menudeo', 'estado', 'categoria_id')
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
            // Verificar si el producto existe
            if (!$producto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado'
                ], 404);
            }

            // Eliminar el producto de la base de datos
            $producto->forceDelete();

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

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'código' => ['required', 'string', 'max:50', 'unique:productos,código,'.$request->id],
            'descripción' => ['required', 'string'],
            'precio_mayoreo' => ['required', 'numeric', 'min:0'],
            'precio_menudeo' => ['required', 'numeric', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'estado' => ['required', 'string', 'in:activo,inactivo']
        ]);

        try {
            // Obtener todos los IDs existentes (incluyendo los eliminados)
            $existingIds = Producto::withTrashed()
                ->orderBy('id')
                ->pluck('id')
                ->toArray();
            
            // Encontrar el primer ID disponible
            $newId = 1;
            foreach ($existingIds as $id) {
                if ($id == $newId) {
                    $newId++;
                } else if ($id > $newId) {
                    break;
                }
            }
            
            // Crear el nuevo producto con el ID disponible
            $producto = new Producto([
                'nombre' => $request->nombre,
                'código' => $request->código,
                'descripción' => $request->descripción,
                'precio_mayoreo' => $request->precio_mayoreo,
                'precio_menudeo' => $request->precio_menudeo,
                'categoria_id' => $request->categoria_id,
                'estado' => $request->estado
            ]);
            $producto->id = $newId;
            $producto->save();

            return redirect()->route('admin.products.index')
                ->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear el producto: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Producto $producto): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'código' => ['required', 'string', 'max:50', 'unique:productos,código,'.$producto->id],
            'descripción' => ['required', 'string'],
            'precio_mayoreo' => ['required', 'numeric', 'min:0'],
            'precio_menudeo' => ['required', 'numeric', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'estado' => ['required', 'string', 'in:activo,inactivo']
        ]);

        $productoData = [
            'nombre' => $request->nombre,
            'código' => $request->código,
            'descripción' => $request->descripción,
            'precio_mayoreo' => $request->precio_mayoreo,
            'precio_menudeo' => $request->precio_menudeo,
            'categoria_id' => $request->categoria_id,
            'estado' => $request->estado
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
