@extends('layouts.admin')

@section('titulo', 'Editar Producto')

@section('contenido')
    <div class="container mx-auto px-4 py-8 min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Editar Producto</h1>
            <a href="{{ route('admin.products.index') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-5 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-md flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-xl p-8 transition-all duration-300 hover:shadow-2xl">
            <form action="{{ route('admin.products.update', $producto->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="form-group">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-box text-blue-500"></i>
                            Nombre del Producto
                        </label>
                        <input type="text" name="nombre" id="nombre"
                            class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('nombre') border-red-500 @enderror"
                            value="{{ $producto->nombre }}" required>
                        @error('nombre')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="precio" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-dollar-sign text-blue-500"></i>
                            Precio
                        </label>
                        <input type="number" step="0.01" name="precio" id="precio"
                            class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('precio') border-red-500 @enderror"
                            value="{{ $producto->precio }}" required>
                        @error('precio')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="stock" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-cubes text-blue-500"></i>
                            Stock
                        </label>
                        <input type="number" name="stock" id="stock"
                            class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('stock') border-red-500 @enderror"
                            value="{{ $producto->stock }}" required>
                        @error('stock')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="categoria_id" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-tags text-blue-500"></i>
                            Categoría
                        </label>
                        <select name="categoria_id" id="categoria_id"
                            class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('categoria_id') border-red-500 @enderror"
                            required>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-span-2">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-align-left text-blue-500"></i>
                            Descripción
                        </label>
                        <textarea name="descripcion" id="descripcion" rows="4"
                            class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('descripcion') border-red-500 @enderror"
                            >{{ $producto->descripcion }}</textarea>
                        @error('descripcion')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Guardar Cambios</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection