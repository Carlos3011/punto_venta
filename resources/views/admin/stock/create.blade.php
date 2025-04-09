@extends('layouts.admin')

@section('titulo', 'Registrar Movimiento de Stock')

@section('contenido')
    <div class="container mx-auto px-4 py-8 min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Registrar Movimiento de Stock</h1>
            <a href="{{ route('admin.stock.index') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-5 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-md flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-xl p-8 transition-all duration-300 hover:shadow-2xl">
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
            <form action="{{ route('admin.stock.store') }}" method="POST" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="producto_id" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-box text-blue-500"></i>
                                Producto
                            </label>
                            <select name="producto_id" id="producto_id"
                                class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('producto_id') border-red-500 @enderror"
                                required>
                                <option value="">Seleccionar Producto</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                        {{ $producto->nombre }} - Stock actual: {{ $producto->stock }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tipo_movimiento" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-exchange-alt text-blue-500"></i>
                                Tipo de Movimiento
                            </label>
                            <select name="tipo_movimiento" id="tipo_movimiento"
                                class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('tipo_movimiento') border-red-500 @enderror"
                                required>
                                <option value="">Seleccionar Tipo</option>
                                <option value="entrada" {{ old('tipo_movimiento') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                                <option value="salida" {{ old('tipo_movimiento') == 'salida' ? 'selected' : '' }}>Salida</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="cantidad" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-cubes text-blue-500"></i>
                                Cantidad
                            </label>
                            <input type="number" name="cantidad" id="cantidad"
                                class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('cantidad') border-red-500 @enderror"
                                value="{{ old('cantidad') }}" required min="1">
                        </div>

                        <div class="form-group">
                            <label for="fecha_movimiento" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-calendar text-blue-500"></i>
                                Fecha de Movimiento
                            </label>
                            <input type="datetime-local" name="fecha_movimiento" id="fecha_movimiento"
                                class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('fecha_movimiento') border-red-500 @enderror"
                                value="{{ old('fecha_movimiento', now()->format('Y-m-d\TH:i')) }}" required>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="form-group">
                            <label for="observaciones" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-comment text-blue-500"></i>
                                Observaciones
                            </label>
                            <textarea name="observaciones" id="observaciones" rows="4"
                                class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('observaciones') border-red-500 @enderror"
                                >{{ old('observaciones') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Guardar Movimiento</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection