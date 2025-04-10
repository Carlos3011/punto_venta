<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $products = Producto::with(['categoria', 'proveedores', 'stock'])
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
            if ($request->order_by === 'stock') {
                $query->withCount(['stock as stock_total' => function($query) {
                    $query->select(\DB::raw('SUM(cantidad)'));
                }])->orderBy('stock_total', $request->direction);
            } else {
                $query->orderBy($request->order_by, $request->direction);
            }
        })
        ->withCount(['stock as stock_actual' => function($query) {
            $query->select(\DB::raw('SUM(cantidad)'));
        }])
        ->paginate($request->per_page ?? 10);

    $categorias = Categoria::all();

    return view('admin.products.index', compact('products', 'categorias'));
}

    public function create()
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('admin.products.create', compact('categorias', 'proveedores'));
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('admin.products.edit', compact('producto', 'categorias', 'proveedores'));
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
            'código' => ['required', 'string', 'max:50', 'unique:productos,código'],
            'descripción' => ['required', 'string'],
            'precio_mayoreo' => ['required', 'numeric', 'min:0'],
            'precio_menudeo' => ['required', 'numeric', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'estado' => ['required', 'string', 'in:activo,inactivo'],
            'proveedor_option' => ['required', 'string', 'in:existente,nuevo'],
            'proveedor_id' => ['required_if:proveedor_option,existente', 'exists:proveedores,id', 'nullable'],
            'proveedor_nombre' => ['required_if:proveedor_option,nuevo', 'string', 'max:255', 'nullable'],
            'proveedor_contacto' => ['required_if:proveedor_option,nuevo', 'string', 'max:255', 'nullable'],
            'proveedor_teléfono' => ['required_if:proveedor_option,nuevo', 'string', 'max:20', 'nullable'],
            'proveedor_email' => ['required_if:proveedor_option,nuevo', 'email', 'max:255', 'nullable'],
            'proveedor_option' => ['required', 'string', 'in:existente,nuevo'],
            'proveedor_id' => ['required_if:proveedor_option,existente', 'exists:proveedores,id', 'nullable'],
            'proveedor_nombre' => ['required_if:proveedor_option,nuevo', 'string', 'max:255', 'nullable'],
            'proveedor_contacto' => ['required_if:proveedor_option,nuevo', 'string', 'max:255', 'nullable'],
            'proveedor_teléfono' => ['required_if:proveedor_option,nuevo', 'string', 'max:20', 'nullable'],
            'proveedor_email' => ['required_if:proveedor_option,nuevo', 'email', 'max:255', 'nullable']
        ]);

        try {
            \DB::beginTransaction();

            $producto = Producto::create([
                'nombre' => $request->nombre,
                'código' => $request->código,
                'descripción' => $request->descripción,
                'precio_mayoreo' => $request->precio_mayoreo,
                'precio_menudeo' => $request->precio_menudeo,
                'categoria_id' => $request->categoria_id,
                'estado' => $request->estado
            ]);

            if ($request->proveedor_option === 'nuevo') {
                $proveedor = Proveedor::create([
                    'nombre' => $request->proveedor_nombre,
                    'contacto' => $request->proveedor_contacto,
                    'teléfono' => $request->proveedor_teléfono,
                    'email' => $request->proveedor_email
                ]);
                $producto->proveedores()->attach($proveedor->id);
            } else {
                $producto->proveedores()->attach($request->proveedor_id);
            }

            \DB::commit();
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
            'estado' => ['required', 'string', 'in:activo,inactivo'],
            'proveedor_option' => ['required', 'string', 'in:existente,nuevo'],
            'proveedor_id' => ['required_if:proveedor_option,existente', 'exists:proveedores,id', 'nullable'],
            'proveedor_nombre' => ['required_if:proveedor_option,nuevo', 'string', 'max:255', 'nullable'],
            'proveedor_contacto' => ['required_if:proveedor_option,nuevo', 'string', 'max:255', 'nullable'],
            'proveedor_teléfono' => ['required_if:proveedor_option,nuevo', 'string', 'max:20', 'nullable'],
            'proveedor_email' => ['required_if:proveedor_option,nuevo', 'email', 'max:255', 'nullable']
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
            \DB::beginTransaction();

            $producto->update($productoData);

            if ($request->proveedor_option === 'nuevo') {
                $proveedor = Proveedor::create([
                    'nombre' => $request->proveedor_nombre,
                    'contacto' => $request->proveedor_contacto,
                    'teléfono' => $request->proveedor_teléfono,
                    'email' => $request->proveedor_email
                ]);
                $producto->proveedores()->sync([$proveedor->id]);
            } else {
                $producto->proveedores()->sync([$request->proveedor_id]);
            }

            \DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Producto actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el producto: ' . $e->getMessage());
        }
    }
}
