@extends('layouts.admin')

@section('titulo', 'Gestión de Clientes')

@section('contenido')
<div class="container mx-auto px-4 py-8 animate-fade-in">
    <div class="bg-orange-100 p-6 rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center space-x-4">
                <i class="fas fa-users text-4xl text-orange-500"></i>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent">
                    Gestión de Clientes
                </h1>
            </div>
            <a href="{{ route('admin.clients.create') }}"
                class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-100 hover:shadow-xl flex items-center space-x-2 has-tooltip shadow-md hover:shadow-lg">
                <i class="fas fa-plus text-lg"></i>
                <span>Nuevo Cliente</span>
            </a>
        </div>

        <!-- Tabla de Clientes -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 transform transition-all duration-300 hover:shadow-xl">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RFC</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($clientes as $cliente)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cliente->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cliente->telefono }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cliente->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cliente->rfc }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2 flex">
                                <a href="{{ route('admin.clients.edit', $cliente) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md transition-colors flex items-center gap-1">
                                    <i class="fas fa-edit"></i>
                                    <span>Editar</span>
                                </a>
                                <form action="{{ route('admin.clients.destroy', $cliente) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md transition-colors flex items-center gap-1"
                                        onclick="return confirm('¿Está seguro de eliminar este cliente?')">
                                        <i class="fas fa-trash"></i>
                                        <span>Eliminar</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="mt-4">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection