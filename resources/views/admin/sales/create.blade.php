@extends('layouts.admin')

@section('titulo', 'Nueva Venta')

@section('contenido')
<div class="container mx-auto px-4 py-8 animate-fade-in">
    <div class="bg-orange-100 p-6 rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center space-x-4">
                <i class="fas fa-cart-plus text-4xl text-orange-500"></i>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent">
                    Nueva Venta
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
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg mb-6" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form id="ventaForm" action="{{ route('admin.sales.store') }}" method="POST" class="space-y-6">
                @csrf
                <!-- Sección de Información de Venta -->
                <div class="space-y-4 bg-gray-50 p-4 rounded-lg mb-6">
                    <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Información de Venta</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="space-y-2">
                            <label for="cliente" class="block text-sm font-medium text-gray-700">Cliente</label>
                            <select name="cliente_id" id="cliente"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                                <option value="">Sin cliente registrado</option>
                                @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="forma_pago" class="block text-sm font-medium text-gray-700">Forma de Pago</label>
                            <select name="forma_pago" id="forma_pago"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="transferencia">Transferencia</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="descuento" class="block text-sm font-medium text-gray-700">Descuento ($)</label>
                            <input type="number" name="descuento" id="descuento" min="0" step="0.01" value="0"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                        </div>
                    </div>
                </div>

                <!-- Sección de Productos -->
                <div class="space-y-4 bg-gray-50 p-4 rounded-lg">
                        <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Lista de Productos</h2>
                        
                        <div class="overflow-x-auto rounded-lg border border-gray-200 mb-4">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">P. Mayoreo</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">P. Menudeo</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Proveedor</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($productos as $producto)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $producto->id }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $producto->código }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $producto->nombre }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">${{ number_format($producto->precio_mayoreo, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">${{ number_format($producto->precio_menudeo, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $producto->stock_actual }}</td>                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            @if($producto->proveedores->isNotEmpty())
                                                <span class="px-4 py-1.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-full text-xs font-semibold shadow-sm">
                                                    {{ $producto->proveedores->first()->nombre }}
                                                </span>
                                            @else
                                                <span class="px-4 py-1.5 bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-full text-xs font-semibold shadow-sm">
                                                    Sin proveedor
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            <button type="button" 
                                                class="bg-orange-500 text-white px-3 py-1 rounded-md hover:bg-orange-600 transition-colors flex items-center gap-1 agregarProducto"
                                                data-id="{{ $producto->id }}"
                                                data-nombre="{{ $producto->nombre }}"
                                                data-precio="{{ $producto->precio_menudeo }}"
                                                data-stock="{{ $producto->stock_actual }}">
                                                <i class="fas fa-plus"></i>
                                                <span>Agregar</span>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="productosTabla" class="bg-white divide-y divide-gray-200"></tbody>
                            </table>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                            <span class="text-lg font-semibold">Total:</span>
                            <span id="total" class="text-2xl font-bold text-orange-600">$0.00</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-md flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        <span>Guardar Venta</span>
                    </button>
                </div>

                <input type="hidden" name="productos" id="productosHidden">
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ventaForm = document.getElementById('ventaForm');
    const productosTabla = document.getElementById('productosTabla');
    const totalElement = document.getElementById('total');
    const productosHidden = document.getElementById('productosHidden');
    const descuentoInput = document.getElementById('descuento');

    // Evento para agregar productos
    document.querySelectorAll('.agregarProducto').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const precio = parseFloat(this.dataset.precio);
            const stock = parseInt(this.dataset.stock);

            if (stock <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Sin stock',
                    text: 'No hay stock disponible para este producto',
                    confirmButtonColor: '#f97316'
                });
                return;
            }

            agregarProductoDesdeTabla(id, nombre, precio);
        });
    });

    let productos = new Map();
    let total = 0;
    let subtotal = 0;
    actualizarProductosHidden();

    function productoExiste(id) {
        return productos.has(id);
    }

    function formatMoneda(valor) {
        return `$${Math.max(parseFloat(valor), 0).toFixed(2)}`;
    }

    function calcularTotal() {
        subtotal = Array.from(productos.values())
            .reduce((sum, prod) => sum + (prod.precio * prod.cantidad), 0);
        const descuento = Math.min(parseFloat(descuentoInput.value) || 0, subtotal);
        total = subtotal - descuento;
        totalElement.textContent = formatMoneda(total);
        descuentoInput.max = subtotal;
    }

    function actualizarProductosHidden() {
        const productosArray = Array.from(productos.entries())
            .map(([id, producto]) => ({
                producto_id: parseInt(id),
                cantidad: producto.cantidad,
                precio: producto.precio
            }));
        productosHidden.value = JSON.stringify(productosArray);
    }

    function crearFilaProducto(id, producto) {
        const tr = document.createElement('tr');
        tr.id = `producto-${id}`;
        tr.classList.add('hover:bg-gray-50');
        tr.innerHTML = `
            <td class="px-4 py-3 text-sm text-gray-900">${producto.nombre}</td>
            <td class="px-4 py-3 text-sm text-gray-900">
                <input type="number" min="1" value="${producto.cantidad}"
                    class="w-20 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500"
                    data-producto-id="${id}">
            </td>
            <td class="px-4 py-3 text-sm text-gray-900">${formatMoneda(producto.precio)}</td>
            <td class="px-4 py-3 text-sm text-gray-900 subtotal">${formatMoneda(producto.precio * producto.cantidad)}</td>
            <td class="px-4 py-3 text-sm text-gray-900">
                <button type="button" class="text-red-600 hover:text-red-900 transition-colors duration-200"
                    data-eliminar-id="${id}" onclick="eliminarProducto('${id}')">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        productosTabla.appendChild(tr);
        calcularTotal();
        actualizarProductosHidden();
        return tr;
    }

    function actualizarFilaProducto(id) {
        const producto = productos.get(id);
        if (!producto) return;

        const fila = document.getElementById(`producto-${id}`);
        if (fila) {
            const cantidadInput = fila.querySelector('input[type="number"]');
            const subtotalCell = fila.querySelector('.subtotal');
            cantidadInput.value = producto.cantidad;
            subtotalCell.textContent = formatMoneda(producto.precio * producto.cantidad);
        }
    }

    window.agregarProductoDesdeTabla = function(id, nombre, precio) {
        if (!id || !nombre || isNaN(precio) || precio <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Datos del producto no válidos',
                confirmButtonColor: '#f97316'
            });
            return;
        }

        try {
            let producto;
            if (productos.has(id)) {
                producto = productos.get(id);
                producto.cantidad++;
            } else {
                producto = { nombre, precio, cantidad: 1 };
            }
            
            productos.set(id, producto);
            
            if (document.getElementById(`producto-${id}`)) {
                actualizarFilaProducto(id);
            } else {
                crearFilaProducto(id, producto);
            }
            
            calcularTotal();
            actualizarProductosHidden();

            const mensaje = productos.has(id) ? 
                'Se incrementó la cantidad del producto' : 
                'El producto se agregó correctamente';

            Swal.fire({
                icon: 'success',
                title: productos.has(id) ? 'Cantidad actualizada' : 'Producto agregado',
                text: mensaje,
                confirmButtonColor: '#f97316',
                timer: 1500,
                showConfirmButton: false
            });

        } catch (error) {
            console.error('Error al agregar producto:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al agregar el producto',
                confirmButtonColor: '#f97316'
            });
        }
    }

    productosTabla.addEventListener('change', (e) => {
        if (e.target.type === 'number') {
            const id = e.target.dataset.productoId;
            const producto = productos.get(id);
            if (producto) {
                const cantidad = parseInt(e.target.value) || 1;
                if (cantidad < 1) {
                    e.target.value = 1;
                    producto.cantidad = 1;
                } else {
                    producto.cantidad = cantidad;
                }
                productos.set(id, producto);
                actualizarFilaProducto(id);
                calcularTotal();
                actualizarProductosHidden();
            }
        }
    });

    window.eliminarProducto = function(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar este producto de la venta?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f97316',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                productos.delete(id);
                document.getElementById(`producto-${id}`).remove();
                calcularTotal();
                actualizarProductosHidden();
                Swal.fire({
                    icon: 'success',
                    title: 'Producto eliminado',
                    text: 'El producto se eliminó correctamente de la venta',
                    confirmButtonColor: '#f97316',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    };

    productosTabla.addEventListener('click', (e) => {
        const button = e.target.closest('button[data-eliminar-id]');
        if (button && !button.hasAttribute('onclick')) {
            const id = button.dataset.eliminarId;
            eliminarProducto(id);
        }
    });

    descuentoInput.addEventListener('input', () => {
        calcularTotal();
    });

    ventaForm.addEventListener('submit', (e) => {
        e.preventDefault();
        if (productos.size === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe agregar al menos un producto a la venta',
                confirmButtonColor: '#f97316'
            });
            return;
        }
        ventaForm.submit();
    });
});
</script>
@endpush
@endsection