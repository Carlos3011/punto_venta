<?php

namespace App\Http\Controllers;

use App\Models\ReporteVenta;
use App\Models\Venta;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteVentaController extends Controller
{
    public function index()
    {
        return view('admin.sales.index');
    }

    public function obtenerDatos(Request $request)
    {
        $tipo = $request->tipo ?? 'dia';
        $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fechaFin = Carbon::parse($request->fecha_fin)->endOfDay();

        $ventas = Venta::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->select(
                DB::raw('DATE(fecha) as fecha'),
                DB::raw('SUM(total) as total_ventas'),
                DB::raw('SUM(descuento) as total_descuentos'),
                DB::raw("SUM(CASE WHEN forma_pago = 'efectivo' THEN total ELSE 0 END) as ventas_efectivo"),
                DB::raw("SUM(CASE WHEN forma_pago = 'tarjeta' THEN total ELSE 0 END) as ventas_tarjeta"),
                DB::raw("SUM(CASE WHEN forma_pago = 'transferencia' THEN total ELSE 0 END) as ventas_transferencia")
            )
            ->groupBy('fecha')
            ->get();

        $cajas = Caja::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->select(
                'fecha',
                DB::raw('SUM(total_gastos) as gastos_totales')
            )
            ->groupBy('fecha')
            ->get();

        $datos = [
            'ventas' => $ventas,
            'cajas' => $cajas,
            'utilidades' => $ventas->map(function ($venta) use ($cajas) {
                $gastosDia = $cajas->where('fecha', $venta->fecha)->first()?->gastos_totales ?? 0;
                return [
                    'fecha' => $venta->fecha,
                    'utilidad' => $venta->total_ventas - $gastosDia
                ];
            })
        ];

        return response()->json($datos);
    }

    public function exportarExcel(Request $request)
    {
        // TODO: Implementar exportación a Excel
        return response()->download('ruta_al_archivo_excel');
    }

    public function exportarPDF(Request $request)
    {
        // TODO: Implementar exportación a PDF
        return response()->download('ruta_al_archivo_pdf');
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::whereHas('stock', function($query) {
            $query->select('producto_id')
                  ->groupBy('producto_id')
                  ->havingRaw('SUM(CASE WHEN tipo_movimiento = "entrada" THEN cantidad ELSE -cantidad END) > 0');
        })->get();
        return view('admin.sales.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'forma_pago' => 'required|in:efectivo,tarjeta,transferencia',
            'descuento' => 'nullable|numeric|min:0',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'user_id' => auth()->id(),
                'fecha' => now(),
                'forma_pago' => $request->forma_pago,
                'descuento' => $request->descuento ?? 0,
                'total' => 0
            ]);

            $total = 0;
            foreach ($request->productos as $producto) {
                $item = Producto::findOrFail($producto['id']);
                if ($item->stock < $producto['cantidad']) {
                    throw new \Exception('Stock insuficiente para ' . $item->nombre);
                }

                $subtotal = $item->precio_venta * $producto['cantidad'];
                $total += $subtotal;

                $venta->detalles()->create([
                    'producto_id' => $item->id,
                    'cantidad' => $producto['cantidad'],
                    'precio_unitario' => $item->precio_venta,
                    'subtotal' => $subtotal
                ]);

                $item->decrement('stock', $producto['cantidad']);
            }

            $venta->update(['total' => $total - ($request->descuento ?? 0)]);
            DB::commit();

            return redirect()->route('admin.sales.index')
                ->with('success', 'Venta registrada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}