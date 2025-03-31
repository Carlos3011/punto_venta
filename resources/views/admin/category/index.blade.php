@extends('layouts.admin')

@section('titulo', 'Listado de Categorías')

@section('contenido')
    <div class="container mx-auto px-4 py-8 animate-fade-in">
        <div class="bg-orange-100 p-6 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-boxes text-4xl text-blue-500"></i>
                    <h1 class="text-3xl font-bold bg-blue-500 bg-clip-text text-transparent">
                        Gestión de Categorías</h1>
                </div>
                <a href="{{ route('admin.category.create') }}"
                    class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-100 hover:shadow-xl flex items-center space-x-2 shadow-md hover:shadow-lg">
                    <i class="fas fa-plus text-lg"></i>
                    <span>Nueva Categoría</span>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 transform transition-all duration-300 hover:shadow-xl">
                <form action="{{ route('admin.category.index') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Nombre o descripción...">
                    </div>
                    <div class="md:col-span-2 lg:col-span-3 flex justify-end space-x-4">
                        <button type="submit"
                            class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-search mr-2"></i>Buscar
                        </button>
                        <a href="{{ route('admin.category.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-all duration-200">
                            <i class="fas fa-undo mr-2"></i>Restablecer
                        </a>
                    </div>
                </form>
            </div>

            <div
                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-gray-100 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ route('admin.category.index', ['order_by' => 'nombre', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['order_by', 'direction'])) }}"
                                    class="flex items-center hover:text-blue-500 transition-colors duration-200">
                                    <i class="fas fa-tag mr-2 text-blue-400"></i>Nombre
                                    @if(request('order_by') == 'nombre')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-2"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                <i class="fas fa-cogs mr-2 text-blue-400"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($categorias as $categoria)
                            <tr class="hover:bg-blue-50 transition-all duration-200 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-700">{{ $categoria->nombre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.category.edit', $categoria) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-all duration-200">
                                            <i class="fas fa-edit mr-1.5"></i>
                                            Editar
                                        </a>
                                        <form action="{{ route('admin.category.destroy', $categoria) }}" method="POST"
                                            onsubmit="return confirm('¿Estás seguro de eliminar esta categoría?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-all duration-200">
                                                <i class="fas fa-trash-alt mr-1.5"></i>
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
@endsection