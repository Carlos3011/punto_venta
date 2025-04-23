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
            <form action="{{ route('admin.products.update', $producto) }}" method="POST" class="space-y-6">
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
                        <label for="código" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-barcode text-blue-500"></i>
                            Código
                        </label>
                        <input type="text" name="código" id="código"
                            class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('código') border-red-500 @enderror"
                            value="{{ $producto->código }}" required>
                        @error('código')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label for="precio_mayoreo" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-dollar-sign text-blue-500"></i>
                                Precio Mayoreo
                            </label>
                            <input type="number" step="0.01" name="precio_mayoreo" id="precio_mayoreo"
                                class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('precio_mayoreo') border-red-500 @enderror"
                                value="{{ $producto->precio_mayoreo }}" required>
                            @error('precio_mayoreo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="precio_menudeo" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-dollar-sign text-blue-500"></i>
                                Precio Menudeo
                            </label>
                            <input type="number" step="0.01" name="precio_menudeo" id="precio_menudeo"
                                class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('precio_menudeo') border-red-500 @enderror"
                                value="{{ $producto->precio_menudeo }}" required>
                            @error('precio_menudeo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="estado" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-toggle-on text-blue-500"></i>
                            Estado
                        </label>
                        <select name="estado" id="estado"
                            class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('estado') border-red-500 @enderror"
                            required>
                            <option value="activo" {{ $producto->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ $producto->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
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
                        <label for="descripción" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-align-left text-blue-500"></i>
                            Descripción
                        </label>
                        <textarea name="descripción" id="descripción" rows="4"
                            class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('descripción') border-red-500 @enderror"
                            required>{{ $producto->descripción }}</textarea>
                        @error('descripción')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-span-2">
                        <label class="block text-sm font-medium text-gray-700 flex items-center gap-2 mb-4">
                            <i class="fas fa-truck text-blue-500"></i>
                            Proveedor
                        </label>
                        
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <input type="radio" name="proveedor_option" id="proveedor_existente" value="existente" 
                                    class="text-orange-500 focus:ring-orange-500" 
                                    {{ $producto->proveedores->isEmpty() ? '' : 'checked' }}>
                                <label for="proveedor_existente" class="text-sm text-gray-700">Seleccionar proveedor existente</label>
                            </div>

                            <div id="proveedor_existente_section" class="ml-8">
                                <select name="proveedor_id" id="proveedor_id"
                                    class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('proveedor_id') border-red-500 @enderror">
                                    <option value="">Seleccione un proveedor</option>
                                    @foreach($proveedores as $proveedor)
                                        <option value="{{ $proveedor->id }}" {{ $producto->proveedores->contains($proveedor->id) ? 'selected' : '' }}>
                                            {{ $proveedor->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('proveedor_id')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex items-center space-x-4">
                                <input type="radio" name="proveedor_option" id="proveedor_nuevo" value="nuevo" 
                                    class="text-orange-500 focus:ring-orange-500"
                                    {{ $producto->proveedores->isEmpty() ? 'checked' : '' }}>
                                <label for="proveedor_nuevo" class="text-sm text-gray-700">Crear nuevo proveedor</label>
                            </div>

                            <div id="proveedor_nuevo_section" class="ml-8 space-y-4">
                                <div>
                                    <label for="proveedor_nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                    <input type="text" name="proveedor_nombre" id="proveedor_nombre"
                                        class="mt-1 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('proveedor_nombre') border-red-500 @enderror">
                                    @error('proveedor_nombre')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="proveedor_contacto" class="block text-sm font-medium text-gray-700">Contacto</label>
                                    <input type="text" name="proveedor_contacto" id="proveedor_contacto"
                                        class="mt-1 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('proveedor_contacto') border-red-500 @enderror">
                                    @error('proveedor_contacto')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="proveedor_teléfono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                    <input type="text" name="proveedor_teléfono" id="proveedor_teléfono"
                                        class="mt-1 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('proveedor_teléfono') border-red-500 @enderror">
                                    @error('proveedor_teléfono')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="proveedor_email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="proveedor_email" id="proveedor_email"
                                        class="mt-1 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('proveedor_email') border-red-500 @enderror">
                                    @error('proveedor_email')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
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