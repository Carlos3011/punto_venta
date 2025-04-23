e<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $ventas = Venta::with(['cliente', 'productos'])->paginate(10);
        return view('admin.sales.index', compact('ventas'));
    }

    public function create()
    {
        $productos = Producto::where('stock', '>', 0)->get();
        $clientes = Cliente::all();
        return view('admin.sales.create', compact('productos', 'clientes'));
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1'
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        if ($producto->stock < $request->cantidad) {
            return response()->json([
                'error' => 'Stock insuficiente'
            ], 422);
        }

        // Aquí manejaremos la lógica del carrito de compras usando la sesión
        $cart = session()->get('cart', []);

        if (isset($cart[$request->producto_id])) {
            $cart[$request->producto_id]['cantidad'] += $request->cantidad;
        } else {
            $cart[$request->producto_id] = [
                'nombre' => $producto->nombre,
                'precio' => $producto->precio_venta,
                'cantidad' => $request->cantidad
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'message' => 'Producto agregado al carrito',
            'cart' => $cart
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'total' => 0,
                'fecha' => now()
            ]);

            $total = 0;
            foreach ($request->productos as $producto) {
                $item = Producto::findOrFail($producto['id']);
                $subtotal = $item->precio_venta * $producto['cantidad'];
                $total += $subtotal;

                // Actualizar el stock
                $item->stock -= $producto['cantidad'];
                $item->save();

                // Registrar detalle de venta
                $venta->productos()->attach($item->id, [
                    'cantidad' => $producto['cantidad'],
                    'precio_unitario' => $item->precio_venta,
                    'subtotal' => $subtotal
                ]);
            }

            $venta->update(['total' => $total]);
            DB::commit();

            // Limpiar el carrito
            session()->forget('cart');

            return redirect()->route('admin.sales.index')
                ->with('success', 'Venta registrada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al registrar la venta'])
                ->withInput();
        }
    }

    public function show(Venta $venta)
    {
        return view('admin.sales.show', compact('venta'));
    }
}