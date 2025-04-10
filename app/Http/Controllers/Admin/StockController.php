<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Stock;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('producto')->paginate(15);
        return view('admin.stock.index', compact('stocks'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('admin.stock.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:0',
            'tipo_movimiento' => 'required|in:entrada,salida'
        ]);

        Stock::create($request->all());

        return redirect()->route('admin.stock.index')
            ->with('success', 'Movimiento de stock registrado exitosamente.');
    }

    public function edit(Stock $stock)
    {
        $productos = Producto::all();
        return view('admin.stock.edit', compact('stock', 'productos'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:0',
            'tipo_movimiento' => 'required|in:entrada,salida'
        ]);

        $stock->update($request->all());

        return redirect()->route('admin.stock.index')
            ->with('success', 'Movimiento de stock actualizado exitosamente.');
    }

    public function destroy(Stock $stock)
    {
        try {
            // Verificar si el movimiento de stock existe
            if (!$stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Movimiento de stock no encontrado'
                ], 404);
            }

            // Eliminar el movimiento de stock
            $stock->delete();

            return response()->json([
                'success' => true,
                'message' => 'Movimiento de stock eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el movimiento de stock: ' . $e->getMessage()
            ], 500);
        }
    }
}