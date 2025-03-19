<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Instalador - Accesorios Led "El Güero"</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <nav x-data="{ open: false }" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] bg-gradient-to-b from-blue-800 via-blue-700 to-blue-600 shadow-xl" :class="{'translate-x-0': open || $screen('md'), '-translate-x-full': !open && !$screen('md')}">
            <div x-show="open" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity md:hidden" @click="open = false"></div>
            <div class="p-4">
                <img src="{{ asset('img/logo-blanco-lineal.png') }}" class="h-8 mx-auto mb-6" alt="Logo" />
                <div class="space-y-2">
                    <a href="#" class="flex items-center p-2 text-white hover:bg-blue-700 rounded-lg transition-colors">
                        <i class="fas fa-server mr-3"></i>
                        <span>Requisitos del Sistema</span>
                    </a>
                    <a href="#" class="flex items-center p-2 text-white hover:bg-blue-700 rounded-lg transition-colors">
                        <i class="fas fa-database mr-3"></i>
                        <span>Base de Datos</span>
                    </a>
                    <a href="#" class="flex items-center p-2 text-white hover:bg-blue-700 rounded-lg transition-colors">
                        <i class="fas fa-cog mr-3"></i>
                        <span>Configuración</span>
                    </a>
                    <a href="#" class="flex items-center p-2 text-white hover:bg-blue-700 rounded-lg transition-colors">
                        <i class="fas fa-flag-checkered mr-3"></i>
                        <span>Finalizar Instalación</span>
                    </a>

                    <!-- User Profile Section -->
                <div class="mt-8 sm:mt-10 pt-6 sm:pt-8 border-t border-blue-400 border-opacity-50">
                    <div class="flex items-center px-4 py-4 text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl group transition-all hover:from-blue-500 hover:to-blue-600">
                        <i class="fas fa-user-circle text-2xl mr-3"></i>
                        <div>
                            <p class="font-medium">{{ Auth::user()->name }}</p>
                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <button type="submit" class="flex items-center text-sm text-white hover:text-orange-300 transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </nav>

        <main class="flex-1 pb-8">
            <!-- Header -->
            <div class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-semibold text-gray-900">Instalación del Sistema</h1>
                    <!-- Barra de Progreso -->
                    <div class="mt-4 w-full" x-data="{ step: 1, totalSteps: 4 }">
                        <div class="relative">
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                                <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600"
                                    :style="'width: ' + (step / totalSteps * 100) + '%'"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenido Principal -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="bg-white shadow-xl rounded-lg p-8">
                    @yield('content')
                </div>
            </div>

            <!-- Pie de Página -->
            <footer class="mt-8 border-t border-gray-200">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-sm text-gray-500 text-center">
                    &copy; {{ date('Y') }} Accesorios Led "El Güero". Todos los derechos reservados.
                </div>
            </footer>
        </main>
    </div>
</body>
</html>