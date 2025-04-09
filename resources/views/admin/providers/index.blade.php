@extends('layouts.admin')

@section('titulo', 'Gestión de Proveedores')

@section('contenido')
    @push('scripts')
    <script>
        function confirmarEliminacion(url) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Eliminando...',
                        text: 'Por favor, espere',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Eliminado',
                                text: data.message,
                                icon: 'success',
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: data.message,
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error',
                            text: 'Ha ocurrido un error al eliminar el proveedor',
                            icon: 'error'
                        });
                    });
                }
            });
        }
    </script>
    @endpush
    <div class="container mx-auto px-4 py-8 animate-fade-in">
        <div class="bg-orange-100 p-6 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-boxes text-4xl text-orange-500"></i>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent">
                        Gestión de Proveedores
                    </h1>
                </div>
                <a href="{{ route('admin.providers.create') }}"
                    class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-100 hover:shadow-xl flex items-center space-x-2 has-tooltip shadow-md hover:shadow-lg">
                    <i class="fas fa-plus text-lg"></i>
                    <span>Nuevo Proveedor</span>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 transform transition-all duration-300 hover:shadow-xl">
                <form action="{{ route('admin.providers.index') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-2">
                        <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                            placeholder="Nombre o contacto...">
                    </div>

                    <div class="md:col-span-2 lg:col-span-4 flex justify-end space-x-4">
                        <button type="submit"
                            class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-200 has-tooltip">
                            <i class="fas fa-search mr-2"></i>Buscar
                        </button>
                        <a href="{{ route('admin.providers.index') }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-all duration-200 has-tooltip">
                            <i class="fas fa-undo mr-2"></i>Restablecer
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 border border-gray-100 overflow-x-auto">
                <table id="tabla-proveedores" class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ route('admin.providers.index', ['order_by' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['order_by', 'direction'])) }}"
                                    class="flex items-center hover:text-orange-500 transition-colors duration-200">
                                    <i class="fas fa-hashtag mr-2 text-orange-400"></i>ID
                                    @if(request('order_by') == 'id')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-2"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ route('admin.providers.index', ['order_by' => 'nombre', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['order_by', 'direction'])) }}"
                                    class="flex items-center hover:text-orange-500 transition-colors duration-200">
                                    <i class="fas fa-user mr-2 text-orange-400"></i>Nombre
                                    @if(request('order_by') == 'nombre')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-2"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ route('admin.providers.index', ['order_by' => 'contacto', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['order_by', 'direction'])) }}"
                                    class="flex items-center hover:text-orange-500 transition-colors duration-200">
                                    <i class="fas fa-id-card mr-2 text-orange-400"></i>Contacto
                                    @if(request('order_by') == 'contacto')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-2"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ route('admin.providers.index', ['order_by' => 'teléfono', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['order_by', 'direction'])) }}"
                                    class="flex items-center hover:text-orange-500 transition-colors duration-200">
                                    <i class="fas fa-phone mr-2 text-orange-400"></i>Teléfono
                                    @if(request('order_by') == 'teléfono')
                                        <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-2"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ route('admin.providers.index', ['order_by' => 'email', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'] + request()->except(['order_by', 'direction'])) }}"
                                    class="flex items-center hover:text-orange-500 transition-colors duration-200">
                                    <i class="fas fa-envelope mr-2 text-orange-400"></i>Email
                                    @if(request('order_by') == 'email')
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
                        @foreach($providers as $provider)
                            <tr class="hover:bg-orange-50 transition-all duration-200 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">{{ $provider->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $provider->nombre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $provider->contacto }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $provider->teléfono }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $provider->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                    <a href="{{ route('admin.providers.edit', $provider) }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-all duration-200 has-tooltip">
                                        <i class="fas fa-edit mr-1.5"></i>
                                        Editar
                                    </a>
                                    <button type="button"
                                        onclick="confirmarEliminacion('{{ route('admin.providers.destroy', $provider) }}')" 
                                        class="inline-flex items-center px-3 py-1.5 bg-orange-50 text-orange-600 rounded-lg hover:bg-orange-100 transition-all duration-200 has-tooltip">
                                        <i class="fas fa-trash-alt mr-1.5"></i>
                                        Eliminar
                                    </button>
                                    <form id="form-eliminar-{{ $provider->id }}" action="{{ route('admin.providers.destroy', $provider) }}"
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
                        {{ $providers->appends(request()->query())->links() }}
                    </div>

                    <div class="flex items-center space-x-4">
                        <form method="GET" action="{{ route('admin.providers.index') }}" class="flex items-center space-x-2">
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