@extends('layouts.admin')

@section('titulo', 'Editar Venta')

@section('contenido')
    <div class="container mx-auto px-4 py-8 animate-fade-in">
        <div class="bg-orange-100 p-6 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-edit text-4xl text-orange-500"></i>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent">
                        Editar Venta
                    </h1>
                </div>
                <a href="{{ route('admin.sales.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2.5 px-5 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-md flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver</span>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 mb-8 transform transition-all duration-300 hover:shadow-xl">
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg relative mb-6 animate-fadeIn"
                        role="alert">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-exclamation-triangle text-xl"></i>
                            <ul class="space-y-2">
                                @foreach ($errors->all() as $error)
                                    <li class="font-medium">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.sales.update', $venta->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label for="cliente" class="block text-sm font-medium text-gray-700 mb-2">Cliente</label>
                                <select name="cliente_id" id="cliente" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                                    <option value="">Seleccione un cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ $venta->cliente_id == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="forma_pago" class="block text-sm font-medium text-gray-700 mb-2">Forma de Pago</label>
                                <select name="forma_pago" id="forma_pago" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                                    <option value="efectivo" {{ $venta->forma_pago == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                                    <option value="tarjeta" {{ $venta->forma_pago == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                    <option value="transferencia" {{ $venta->forma_pago == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                                </select>
                            </div>

                            <div>
                                <label for="descuento" class="block text-sm font-medium text-gray-700 mb-2">Descuento</label>
                                <input type="number" name="descuento" id="descuento" min="0" step="0.01"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500"
                                    value="{{ $venta->descuento }}" placeholder="0.00">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="producto" class="block text-sm font-medium text-gray-700 mb-2">Agregar Producto</label>
                                <div class="flex gap-2">
                                    <select id="producto" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                                        <option value="">Seleccione un producto</option>
                                        @foreach($productos as $producto)
                                            <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_venta }}">{{ $producto->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="agregar_producto"
                                        class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition-colors">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productos_tabla" class="bg-white divide-y divide-gray-200">
                                        <!-- Los productos se agregarán aquí dinámicamente -->
                                    </tbody>
                                </table>
                            </div>

                            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                <span class="text-lg font-semibold">Total:</span>
                                <span id="total" class="text-2xl font-bold text-orange-600">$0.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-md flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            <span>Actualizar Venta</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productos = {};
            let total = 0;

            // Cargar productos existentes de la venta
            @foreach($venta->detalles as $detalle)
                productos['{{ $detalle->producto_id }}'] = {
                    nombre: '{{ $detalle->producto->nombre }}',
                    precio: {{ $detalle->precio }},
                    cantidad: {{ $detalle->cantidad }}
                };
                agregarFilaProducto('{{ $detalle->producto_id }}');
            @endforeach

            document.getElementById('agregar_producto').addEventListener('click', function() {
                const select = document.getElementById('producto');
                const productoId = select.value;
                if (!productoId) return;

                const option = select.options[select.selectedIndex];
                const nombre = option.text;
                const precio = parseFloat(option.dataset.precio);

                if (productos[productoId]) {
                    productos[productoId].cantidad++;
                    actualizarFilaProducto(productoId);
                } else {
                    productos[productoId] = {
                        nombre,
                        precio,
                        cantidad: 1
                    };
                    agregarFilaProducto(productoId);
                }

                actualizarTotal();
            });

            function agregarFilaProducto(productoId) {
                const producto = productos[productoId];
                const tr = document.createElement('tr');
                tr.id = `producto-${productoId}`;
                tr.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${producto.nombre}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <input type="number" min="1" value="${producto.cantidad}" 
                            class="w-20 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500"
                            onchange="actualizarCantidad('${productoId}', this.value)">
                        <input type="hidden" name="productos[${productoId}][cantidad]" value="${producto.cantidad}">
                        <input type="hidden" name="productos[${productoId}][precio]" value="${producto.precio}">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$${producto.precio.toFixed(2)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$${(producto.precio * producto.cantidad).toFixed(2)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <button onclick="eliminarProducto('${productoId}')"
                            class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;

                const tbody = document.getElementById('productos_tabla');
                const existingRow = document.getElementById(`producto-${productoId}`);
                if (existingRow) {
                    tbody.replaceChild(tr, existingRow);
                } else {
                    tbody.appendChild(tr);
                }
            }

            window.actualizarCantidad = function(productoId, cantidad) {
                productos[productoId].cantidad = parseInt(cantidad);
                actualizarFilaProducto(productoId);
                actualizarTotal();
            };

            window.eliminarProducto = function(productoId) {
                const row = document.getElementById(`producto-${productoId}`);
                row.remove();
                delete productos[productoId];
                actualizarTotal();
            };

            function actualizarFilaProducto(productoId) {
                const producto = productos[productoId];
                const row = document.getElementById(`producto-${productoId}`);
                if (!row) return;

                const cantidadInput = row.querySelector('input[type="number"]');
                const cantidadHidden = row.querySelector(`input[name="productos[${productoId}][cantidad]"]`);
                const subtotalCell = row.querySelector('td:nth-child(4)');

                cantidadInput.value = producto.cantidad;
                cantidadHidden.value = producto.cantidad;
                subtotalCell.textContent = `$${(producto.precio * producto.cantidad).toFixed(2)}`;
            }

            function actualizarTotal() {
                total = Object.values(productos).reduce((sum, producto) => {
                    return sum + (producto.precio * producto.cantidad);
                }, 0);

                const descuento = parseFloat(document.getElementById('descuento').value) || 0;
                const totalConDescuento = total - descuento;

                document.getElementById('total').textContent = `$${totalConDescuento.toFixed(2)}`;
            }

            document.getElementById('descuento').addEventListener('input', actualizarTotal);

            // Actualizar total inicial
            actualizarTotal();
        });
    </script>
    @endpush
@endsection