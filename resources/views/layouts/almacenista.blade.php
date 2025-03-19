<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Panel de Almacén - Accesorios Led "El Güero"</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar Navigation -->
        <nav x-data="{ open: false }" class="fixed top-0 left-0 z-40 w-full md:w-72 lg:w-64 h-screen transition-transform duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] bg-gradient-to-b from-blue-800 via-blue-700 to-blue-600 shadow-xl" :class="{'translate-x-0': open || $screen('md'), '-translate-x-full': !open && !$screen('md')}">
            <div x-show="open" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity md:hidden" @click="open = false"></div>
            <button @click="open = !open" type="button" class="fixed top-4 right-4 md:hidden z-50 inline-flex items-center p-2.5 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <span class="sr-only">Abrir menú</span>
                <i class="fas fa-bars w-6 h-6"></i>
            </button>
            <div class="h-full px-4 sm:px-5 py-7 sm:py-8 overflow-y-auto custom-scrollbar scrollbar-w-2 scrollbar-track-blue-100 scrollbar-thumb-blue-400 scrollbar-thumb-rounded-full">
                <div class="flex items-center mb-5 pl-2.5">
                    <img src="{{ asset('img/logo-blanco-lineal.png') }}" class="h-6 mr-3" alt="Logo" />
                    <span class="self-center text-xl font-semibold whitespace-nowrap text-white">Panel Almacén</span>
                </div>
                <ul class="space-y-2.5 sm:space-y-3.5 font-medium">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3.5 text-white/90 hover:text-white rounded-xl transition-all duration-300 group {{ Route::is('dashboard') ? 'bg-orange-500/90 shadow-lg font-semibold border-l-4 border-orange-300' : 'hover:bg-blue-600/50' }} ">
                            <i class="fas fa-tachometer-alt w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 text-white rounded-lg hover:bg-orange-500 group">
                            <i class="fas fa-boxes w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3">Inventario</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 text-white rounded-lg hover:bg-orange-500 group">
                            <i class="fas fa-box-open w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3">Entrada de Productos</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 text-white rounded-lg hover:bg-orange-500 group">
                            <i class="fas fa-dolly w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3">Salida de Productos</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 text-white rounded-lg hover:bg-orange-500 group">
                            <i class="fas fa-clipboard-list w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3">Reportes de Stock</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content Area -->
        <div class="p-4 sm:ml-64">
            <!-- Top Navigation -->
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
                <div class="flex items-center justify-between mb-4">
                    <button @click="open = !open" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <span class="sr-only">Abrir menú</span>
                        <i class="fas fa-bars w-6 h-6"></i>
                    </button>
                    <div class="flex items-center">
                        <span class="text-gray-600 mr-4">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-white bg-orange-500 hover:bg-orange-600 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-4 py-2">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>