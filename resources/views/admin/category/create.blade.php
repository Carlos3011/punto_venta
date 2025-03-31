@extends('layouts.admin')

@section('titulo', 'Crear Categoría')

@section('contenido')
    <div class="container mx-auto px-4 py-8 min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Nueva Categoría</h1>
            <a href="{{ route('admin.category.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2.5 px-5 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-md flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-xl p-8 transition-all duration-300 hover:shadow-2xl">
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg relative mb-6 animate-fadeIn"
                    role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.category.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid gap-6 md:grid-cols-1">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                        <input type="text" name="nombre"
                            class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                            placeholder="Nombre de la categoría" value="{{ old('nombre') }}">
                    </div>
                </div>

                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg flex items-center gap-2 w-full justify-center">
                    <i class="fas fa-save"></i>
                    <span>Guardar Categoría</span>
                </button>
            </form>
        </div>
    </div>
@endsection