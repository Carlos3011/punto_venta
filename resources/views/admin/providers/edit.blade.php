@extends('layouts.admin')

@section('titulo', 'Editar Proveedor')

@section('contenido')
    <div class="container mx-auto px-4 py-8 min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Editar Proveedor</h1>
            <a href="{{ route('admin.providers.index') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-5 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-md flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-xl p-8 transition-all duration-300 hover:shadow-2xl">
            <form action="{{ route('admin.providers.update', $proveedor) }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="form-group">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-building text-blue-500"></i>
                            Nombre de la Empresa
                        </label>
                        <input type="text" name="nombre" id="nombre"
                            class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('nombre') border-red-500 @enderror"
                            value="{{ $proveedor->nombre }}" required>
                        @error('nombre')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contacto" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-user text-blue-500"></i>
                            Nombre del Contacto
                        </label>
                        <input type="text" name="contacto" id="contacto"
                            class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('contacto') border-red-500 @enderror"
                            value="{{ $proveedor->contacto }}" required>
                        @error('contacto')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="teléfono" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-phone text-blue-500"></i>
                            Teléfono
                        </label>
                        <input type="tel" name="teléfono" id="teléfono"
                            class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('teléfono') border-red-500 @enderror"
                            value="{{ $proveedor->teléfono }}" required>
                        @error('teléfono')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-envelope text-blue-500"></i>
                            Correo Electrónico
                        </label>
                        <input type="email" name="email" id="email"
                            class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('email') border-red-500 @enderror"
                            value="{{ $proveedor->email }}" required>
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="estado" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                            <i class="fas fa-toggle-on text-blue-500"></i>
                            Estado
                        </label>
                        <select name="estado" id="estado"
                            class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('estado') border-red-500 @enderror"
                            required>
                            <option value="activo" {{ $proveedor->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ $proveedor->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
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