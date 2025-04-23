@extends('layouts.admin')

@section('titulo', 'Administración de Caja')

@section('contenido')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container mx-auto px-4 py-8 animate-fade-in">
        <div class="bg-orange-100 p-6 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-cash-register text-4xl text-orange-500"></i>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent">
                        Administración de Caja
                    </h1>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end space-x-4 mb-8">
                <a href="{{ route('admin.cash.create') }}"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Realizar Cierre de Caja</span>
                </a>
            </div>

            <!-- Historial de Cierres -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Historial de Cierres</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto Inicial</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Ventas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monto Final</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diferencia</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cierres ?? [] as $cierre)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cierre->fecha }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($cierre->monto_inicial, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($cierre->total_ventas, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($cierre->monto_final, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm {{ $cierre->diferencia < 0 ? 'text-red-500' : 'text-green-500' }}">
                                    ${{ number_format($cierre->diferencia, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $cierre->diferencia == 0 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $cierre->diferencia == 0 ? 'Correcto' : 'Con Ajustes' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.cash.edit', $cierre->id) }}" class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="eliminarCierre({{ $cierre->id }})" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function eliminarCierre(id) {
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
                    fetch(`/admin/cash/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('¡Eliminado!', data.message, 'success')
                            .then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Ocurrió un error al eliminar el cierre', 'error');
                    });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const montoInicialInput = document.querySelector('input[name="monto_inicial"]');
            const totalVentasInput = document.querySelector('input[name="total_ventas"]');
            const montoFinalInput = document.querySelector('input[name="monto_final"]');
            const diferenciaInput = document.querySelector('input[name="diferencia"]');

            function calcularDiferencia() {
                const montoInicial = parseFloat(montoInicialInput.value) || 0;
                const totalVentas = parseFloat(totalVentasInput.value) || 0;
                const montoFinal = parseFloat(montoFinalInput.value) || 0;
                const esperado = montoInicial + totalVentas;
                const diferencia = montoFinal - esperado;
                diferenciaInput.value = diferencia.toFixed(2);
            }

            montoFinalInput.addEventListener('input', calcularDiferencia);
        });
    </script>
    @endpush
@endsection