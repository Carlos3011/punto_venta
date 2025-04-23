@extends('layouts.admin')

@section('titulo', 'Nuevo Cliente')

@section('contenido')
<div class="container mx-auto px-4 py-8 animate-fade-in">
    <div class="bg-orange-100 p-6 rounded-xl shadow-md">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center space-x-4">
                <i class="fas fa-user-plus text-4xl text-orange-500"></i>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-orange-400 bg-clip-text text-transparent">
                    Nuevo Cliente
                </h1>
            </div>
            <a href="{{ route('admin.clients.index') }}"
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

            <form action="{{ route('admin.clients.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre Completo *</label>
                        <input type="text" name="nombre" id="nombre" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500"
                            value="{{ old('nombre') }}">
                    </div>

                    <div class="space-y-2">
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono *</label>
                        <input type="tel" name="telefono" id="telefono" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500"
                            value="{{ old('telefono') }}">
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500"
                            value="{{ old('email') }}">
                    </div>

                    <div class="space-y-2">
                        <label for="rfc" class="block text-sm font-medium text-gray-700">RFC</label>
                        <input type="text" name="rfc" id="rfc"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500"
                            value="{{ old('rfc') }}">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                        <textarea name="direccion" id="direccion" rows="3"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">{{ old('direccion') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-md flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        <span>Guardar Cliente</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection