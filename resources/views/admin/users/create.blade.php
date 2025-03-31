@extends('layouts.admin')

@section('titulo', 'Crear Usuario')

@section('contenido')
    <div class="container mx-auto px-4 py-8 min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Crear Usuario</h1>
            <a href="{{ route('admin.users.index') }}"
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
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="name" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-user text-blue-500"></i>
                                Nombre
                            </label>
                            <input type="text" name="name" id="name"
                                class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('name') border-red-500 @enderror"
                                value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-envelope text-blue-500"></i>
                                Email
                            </label>
                            <input type="email" name="email" id="email"
                                class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('email') border-red-500 @enderror"
                                value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="password" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-lock text-blue-500"></i>
                                Contraseña
                            </label>
                            <input type="password" name="password" id="password"
                                class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-check-circle text-blue-500"></i>
                                Confirmar Contraseña
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3"
                                required>
                        </div>
                    </div>

                    <div class="md:col-span-2 space-y-4">
                        <div class="form-group">
                            <label for="role_id" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                                <i class="fas fa-user-tag text-blue-500"></i>
                                Rol
                            </label>
                            <select name="role_id" id="role_id"
                                class="mt-2 block w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-all duration-300 hover:border-orange-300 p-3 @error('role_id') border-red-500 @enderror"
                                required>
                                <option value="">Seleccionar Rol</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-4">
                                <i class="fas fa-power-off text-blue-500 mr-2"></i>
                                Estado de la cuenta
                            </label>
                            <div class="flex space-x-6">
                                <label class="flex-1 cursor-pointer group">
                                    <div
                                        class="p-4 rounded-xl border-2 transition-all duration-300 {{ old('is_active', '1') == '1' ? 'border-orange-500 bg-orange-50' : 'border-gray-200 hover:border-orange-300' }}">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="is_active" value="1"
                                                class="form-radio text-orange-600 h-5 w-5"
                                                {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                            <span class="font-medium">Activo</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer group">
                                    <div
                                        class="p-4 rounded-xl border-2 transition-all duration-300 {{ old('is_active') == '0' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-red-300' }}">
                                        <div class="flex items-center gap-3">
                                            <input type="radio" name="is_active" value="0"
                                                class="form-radio text-red-600 h-5 w-5"
                                                {{ old('is_active') == '0' ? 'checked' : '' }}>
                                            <span class="font-medium">Inactivo</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg flex items-center gap-3">
                        <i class="fas fa-user-plus"></i>
                        <span>Crear Usuario</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection