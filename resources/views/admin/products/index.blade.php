@extends('layouts.admin')

@section('titulo', 'Gestión de Productos')

@section('contenido')

    <div class="container mx-auto px-4 py-8 animate-fade-in">
        <div class="bg-orange-100 p-6 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-tags text-4xl text-orange-500"></i>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent">
                        Gestión de Productos</h1>
                </div>
                <a href="{{ route('admin.products.create') }}"
                    class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-100 hover:shadow-xl flex items-center space-x-2 has-tooltip shadow-md hover:shadow-lg">
                    <i class="fas fa-plus text-lg"></i>
                    <span>Crear Producto</span>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 transform transition-all duration-300 hover:shadow-xl">
                <form action="{{ route('admin.products.index') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            placeholder="Nombre o código...">
                    </div>

                    <div class="space-y-2">
                        <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select name="categoria_id" id="categoria_id"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2 lg:col-span-4 flex justify-end space-x-4">
                        <button type="submit"
                            class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-200 has-tooltip">
                            <i class="fas fa-search mr-2"></i>Buscar
                        </button>
                        <a href="{{ route('admin.products.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-all duration-200 has-tooltip">
                            <i class="fas fa-undo mr-2"></i>Restablecer
                        </a>
                    </div>
                </form>
            </div>

            <div
                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-gray-100 overflow-x-auto">
                <table id="tabla-productos" class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ route('admin.products.index', ['order_by' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['order_by', 'direction'])) }}"
                                    class="flex items-center hover:text-orange-500 transition-colors duration-200">
                                    <i class="fas fa-hashtag mr-2 text-orange-400"></i>ID
                                    @if(request('order_by') == 'id')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-2"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ route('admin.products.index', ['order_by' => 'nombre', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['order_by', 'direction'])) }}"
                                    class="flex items-center hover:text-orange-500 transition-colors duration-200">
                                    <i class="fas fa-box mr-2 text-orange-400"></i>Nombre
                                    @if(request('order_by') == 'nombre')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-2"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ route('admin.products.index', ['order_by' => 'precio', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['order_by', 'direction'])) }}"
                                    class="flex items-center hover:text-orange-500 transition-colors duration-200">
                                    <i class="fas fa-dollar-sign mr-2 text-orange-400"></i>Precio
                                    @if(request('order_by') == 'precio')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-2"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ route('admin.products.index', ['order_by' => 'stock', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['order_by', 'direction'])) }}"
                                    class="flex items-center hover:text-orange-500 transition-colors duration-200">
                                    <i class="fas fa-cubes mr-2 text-orange-400"></i>Stock
                                    @if(request('order_by') == 'stock')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-2"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ route('admin.products.index', ['order_by' => 'categoria_id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['order_by', 'direction'])) }}"
                                    class="flex items-center hover:text-orange-500 transition-colors duration-200">
                                    <i class="fas fa-list mr-2 text-orange-400"></i>Categoría
                                    @if(request('order_by') == 'categoria_id')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-2"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                <i class="fas fa-cogs mr-2 text-orange-400"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($products as $product)
                            <tr class="hover:bg-orange-50 transition-all duration-200 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">{{ $product->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->nombre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ number_format($product->precio, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <span class="px-4 py-1.5 rounded-full text-xs font-semibold shadow-sm {{ $product->stock > 0 ? 'bg-gradient-to-r from-green-500 to-green-600 text-white' : 'bg-gradient-to-r from-red-500 to-red-600 text-white' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <span class="px-4 py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-full text-xs font-semibold shadow-sm">
                                        {{ $product->categoria->nombre }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-all duration-200 has-tooltip">
                                        <i class="fas fa-edit mr-1.5"></i>
                                        Editar
                                    </a>
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-1.5 bg-orange-50 text-orange-600 rounded-lg hover:bg-orange-100 transition-all duration-200 has-tooltip"
                                        onclick="confirmarEliminacion('{{ route('admin.products.destroy', $product) }}')">
                                        <i class="fas fa-trash-alt mr-1.5"></i>
                                        Eliminar
                                    </button>
                                    <form id="form-eliminar-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}"
                                        method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="flex-1">
                        {{ $products->appends(request()->query())->links() }}
                    </div>

                    <div class="flex items-center space-x-4">
                        <form method="GET" action="{{ route('admin.products.index') }}" class="flex items-center space-x-2">
                            @foreach(request()->except('per_page') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <select name="per_page" onchange="this.form.submit()"
                                class="rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 bg-white">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 por página</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 por página</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 por página</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 por página</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection