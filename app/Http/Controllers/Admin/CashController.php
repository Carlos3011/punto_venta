<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Caja;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $fecha = now()->toDateString();

        // Obtener el registro de caja actual o crear uno nuevo
        $caja = Caja::where('fecha', $fecha)
            ->where('usuario_id', $user->id)
            ->first();

        if (!$caja) {
            $caja = new Caja([
                'usuario_id' => $user->id,
                'fecha' => $fecha,
                'monto_inicial' => 0,
                'total_ventas' => 0,
                'total_efectivo' => 0,
                'total_tarjeta' => 0,
                'total_transferencia' => 0,
                'total_gastos' => 0,
                'diferencia_caja' => 0
            ]);
            $caja->save();
        }

        // Obtener el total de ventas del día
        $total_ventas = Venta::where('fecha', $fecha)
            ->where('user_id', $user->id)
            ->sum('total');

        // Obtener historial de cierres
        $cierres = Caja::where('usuario_id', $user->id)
            ->orderBy('fecha', 'desc')
            ->take(10)
            ->get();

        return view('admin.cash.index', compact('caja', 'total_ventas', 'cierres'));
    }

    public function create()
    {
        $user = Auth::user();
        $fecha = now()->toDateString();

        $caja = Caja::where('fecha', $fecha)
            ->where('usuario_id', $user->id)
            ->firstOrFail();

        $total_ventas = Venta::where('fecha', $fecha)
            ->where('user_id', $user->id)
            ->sum('total');

        return view('admin.cash.create', compact('caja', 'total_ventas'));
    }

    public function close(Request $request)
    {
        $user = Auth::user();
        $fecha = now()->toDateString();

        $caja = Caja::where('fecha', $fecha)
            ->where('usuario_id', $user->id)
            ->firstOrFail();

        $monto_final = $request->input('monto_final');
        $diferencia = $monto_final - ($caja->monto_inicial + $caja->total_ventas);

        $caja->update([
            'diferencia_caja' => $diferencia
        ]);

        return redirect()->route('admin.cash.index')
            ->with('success', 'Cierre de caja realizado correctamente');
    }

    public function edit(Caja $caja)
    {
        $total_ventas = Venta::where('fecha', $caja->fecha)
            ->where('user_id', $caja->usuario_id)
            ->sum('total');

        return view('admin.cash.edit', compact('caja', 'total_ventas'));
    }

    public function update(Request $request, Caja $caja)
    {
        $request->validate([
            'monto_inicial' => 'required|numeric|min:0',
            'monto_final' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string|max:500'
        ]);

        $diferencia = $request->monto_final - ($request->monto_inicial + $caja->total_ventas);

        $caja->update([
            'monto_inicial' => $request->monto_inicial,
            'monto_final' => $request->monto_final,
            'diferencia_caja' => $diferencia,
            'observaciones' => $request->observaciones
        ]);

        return redirect()->route('admin.cash.index')
            ->with('success', 'Cierre de caja actualizado correctamente');
    }

    public function destroy(Caja $caja)
    {
        try {
            $caja->delete();
            return response()->json([
                'success' => true,
                'message' => 'Cierre de caja eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el cierre de caja: ' . $e->getMessage()
            ], 500);
        }
    }
}