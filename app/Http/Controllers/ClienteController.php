<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:clientes,email',
            'rfc' => 'nullable|string|max:13|unique:clientes,rfc',
            'direccion' => 'nullable|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            Cliente::create($request->all());
            DB::commit();

            return redirect()->route('admin.clientes.index')
                ->with('success', 'Cliente registrado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al registrar el cliente'])
                ->withInput();
        }
    }

    public function show(Cliente $cliente)
    {
        return view('admin.clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:clientes,email,' . $cliente->id,
            'rfc' => 'nullable|string|max:13|unique:clientes,rfc,' . $cliente->id,
            'direccion' => 'nullable|string|max:255'
        ]);

        DB::beginTransaction();
        try {
            $cliente->update($request->all());
            DB::commit();

            return redirect()->route('admin.clientes.index')
                ->with('success', 'Cliente actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar el cliente'])
                ->withInput();
        }
    }

    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();
            return redirect()->route('admin.clientes.index')
                ->with('success', 'Cliente eliminado exitosamente');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al eliminar el cliente']);
        }
    }
}