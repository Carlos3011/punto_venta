<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $clientes = Cliente::paginate(10);
        return view('admin.clients.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'teléfono' => 'required|string|max:20|regex:/^[0-9()-]+$/',
            'email' => 'nullable|email|max:255|unique:clientes,email',
            'rfc' => 'nullable|string|size:13|regex:/^[A-Z&Ñ]{3,4}[0-9]{6}[A-Z0-9]{3}$/',
            'dirección' => 'nullable|string|max:500'
        ], [
            'teléfono.regex' => 'El teléfono solo debe contener números y los caracteres () -',
            'rfc.regex' => 'El formato del RFC no es válido',
            'rfc.size' => 'El RFC debe tener exactamente 13 caracteres',
            'email.unique' => 'Este correo electrónico ya está registrado'
        ]);

        try {
            DB::beginTransaction();
            
            $cliente = Cliente::create($request->all());
            
            DB::commit();
            return redirect()->route('admin.clients.index')
                ->with('success', 'Cliente guardado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.clients.create')
                ->with('error', 'Error al guardar el cliente: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Cliente $cliente)
    {
        return view('admin.clients.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('admin.clients.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'teléfono' => 'required|string|max:20|regex:/^[0-9()-]+$/',
            'email' => 'nullable|email|max:255|unique:clientes,email,' . $cliente->id,
            'rfc' => 'nullable|string|size:13|regex:/^[A-Z&Ñ]{3,4}[0-9]{6}[A-Z0-9]{3}$/',
            'dirección' => 'nullable|string|max:500'
        ], [
            'teléfono.regex' => 'El teléfono solo debe contener números y los caracteres () -',
            'rfc.regex' => 'El formato del RFC no es válido',
            'rfc.size' => 'El RFC debe tener exactamente 13 caracteres',
            'email.unique' => 'Este correo electrónico ya está registrado'
        ]);

        try {
            DB::beginTransaction();
            
            $cliente->update($request->all());
            
            DB::commit();
            return redirect()->route('admin.clients.index')
                ->with('success', 'Cliente actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.clients.edit', $cliente)
                ->with('error', 'Error al actualizar el cliente: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Cliente $cliente)
    {
        try {
            DB::beginTransaction();
            
            $cliente->delete();
            
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Cliente eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el cliente: ' . $e->getMessage()
            ], 500);
        }
    }
}