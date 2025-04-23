@extends('layouts.admin')

@section('titulo', 'Cierre de Caja')

@section('contenido')
    <div class="container mx-auto px-4 py-8 animate-fade-in">
        <div class="bg-orange-100 p-6 rounded-xl shadow-md">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-4">
                    <i class="fas fa-cash-register text-4xl text-orange-500"></i>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent">
                        Cierre de Caja
                    </h1>
                </div>
            </div>

            <!-- Formulario de Cierre de Caja -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <form action="{{ route('admin.cash.close') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Monto Inicial -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Monto Inicial</label>
                            <input type="number" name="monto_inicial" step="0.01" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500"
                                value="{{ $caja->monto_inicial ?? '0.00' }}">
                        </div>

                        <!-- Ventas del Día -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total Ventas del Día</label>
                            <input type="number" name="total_ventas" step="0.01" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500"
                                value="{{ $total_ventas ?? '0.00' }}">
                        </div>
                    </div>

                    <!-- Monto Final y Diferencia -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Monto Final en Caja</label>
                            <input type="number" name="monto_final" step="0.01" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500"
                                placeholder="Ingrese el monto final">
                            @error('monto_final')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Diferencia</label>
                            <input type="number" name="diferencia" step="0.01" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500"
                                readonly>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Observaciones</label>
                        <textarea name="observaciones" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500"
                            placeholder="Ingrese observaciones sobre ajustes o diferencias"></textarea>
                        @error('observaciones')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.cash.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300 flex items-center gap-2">
                            <i class="fas fa-times"></i>
                            <span>Cancelar</span>
                        </a>
                        <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300 flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            <span>Realizar Cierre de Caja</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
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

            // Agregar event listeners para todos los campos que afectan el cálculo
            montoInicialInput.addEventListener('input', calcularDiferencia);
            totalVentasInput.addEventListener('input', calcularDiferencia);
            montoFinalInput.addEventListener('input', calcularDiferencia);

            // Calcular diferencia inicial
            calcularDiferencia();
        });
    </script>
    @endpush
@endsection