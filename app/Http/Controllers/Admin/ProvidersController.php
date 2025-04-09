<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProvidersController extends Controller
{
    public function index(Request $request)
    {
        $query = Proveedor::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('contacto', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('order_by')) {
            $direction = $request->get('direction', 'asc');
            $query->orderBy($request->get('order_by'), $direction);
        }

        $perPage = $request->get('per_page', 10);
        $providers = $query->paginate($perPage);

        return view('admin.providers.index', compact('providers'));
    }

    public function create()
    {
        return view('admin.providers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'contacto' => 'required|string|max:255',
            'teléfono' => 'required|string|max:20',
            'email' => 'required|email|max:255'
        ]);

        Proveedor::create($validated);

        return redirect()->route('admin.providers.index')
            ->with('success', 'Proveedor creado exitosamente.');
    }

    public function edit(Proveedor $proveedor)
    {
        return view('admin.providers.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'contacto' => 'required|string|max:255',
            'teléfono' => 'required|string|max:20',
            'email' => 'required|email|max:255'
        ]);

        $proveedor->update($validated);

        return redirect()->route('admin.providers.index')
            ->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();

        return redirect()->route('admin.providers.index')
            ->with('success', 'Proveedor eliminado exitosamente.');
    }
}