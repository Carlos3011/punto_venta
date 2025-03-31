<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Panel de Administración - Accesorios Led "El Güero"</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/lucide.js', 'resources/js/alpine.js', 'resources/js/sweetalert.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar Navigation -->
        <nav x-data="{ open: false, isMediumScreen: window.innerWidth >= 768 }" @resize.window="isMediumScreen = window.innerWidth >= 768" class="fixed top-0 left-0 z-40 w-full md:w-72 lg:w-64 h-screen transition-transform duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] bg-gradient-to-b from-blue-800 via-blue-700 to-blue-600 shadow-xl" :class="{'translate-x-0': open || isMediumScreen, '-translate-x-full': !open && !isMediumScreen}">
            <div x-show="open" class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity md:hidden" @click="open = false"></div>
            <button @click="open = !open" type="button" class="fixed top-4 right-4 md:hidden z-50 inline-flex items-center p-2.5 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <span class="sr-only">Abrir menú</span>
                <i class="fas fa-bars w-6 h-6"></i>
            </button>
            <div class="h-full px-4 sm:px-5 py-7 sm:py-8 overflow-y-auto custom-scrollbar scrollbar-w-2 scrollbar-track-blue-100 scrollbar-thumb-blue-400 scrollbar-thumb-rounded-full">
                <div class="flex flex-col items-center mb-8 sm:mb-10">
                    <img src="{{ asset('img/logo-blanco-lineal.png') }}" class="h-10 mb-4" alt="Logo" />
                </div>
                <ul class="space-y-2.5 sm:space-y-3.5 font-medium">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3.5 text-white/90 hover:text-white rounded-xl transition-all duration-300 group {{ Route::is('dashboard') ? 'bg-orange-500/90 shadow-lg font-semibold border-l-4 border-orange-300' : 'hover:bg-blue-600/50' }} ">
                            <i  class=" w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3.5 text-[15px] tracking-wide">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-3.5 text-white/90 hover:text-white rounded-xl transition-all duration-300 group {{ Route::is('dashboard') ? 'bg-orange-500/90 shadow-lg font-semibold border-l-4 border-orange-300' : 'hover:bg-blue-600/50' }} ">
                            <i class="w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3">Gestión de Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-3.5 text-white/90 hover:text-white rounded-xl transition-all duration-300 group {{ Route::is('dashboard') ? 'bg-orange-500/90 shadow-lg font-semibold border-l-4 border-orange-300' : 'hover:bg-blue-600/50' }} ">
                            <i  class="w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3 text-sm">Gestión de Productos</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-3.5 text-white/90 hover:text-white rounded-xl transition-all duration-300 group {{ Route::is('dashboard') ? 'bg-orange-500/90 shadow-lg font-semibold border-l-4 border-orange-300' : 'hover:bg-blue-600/50' }} ">
                            <i class="w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3 text-sm">Gestión de Stock</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-3.5 text-white/90 hover:text-white rounded-xl transition-all duration-300 group {{ Route::is('dashboard') ? 'bg-orange-500/90 shadow-lg font-semibold border-l-4 border-orange-300' : 'hover:bg-blue-600/50' }} ">
                            <i class="w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3 text-sm">Gestión de Proveedores</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-3.5 text-white/90 hover:text-white rounded-xl transition-all duration-300 group {{ Route::is('dashboard') ? 'bg-orange-500/90 shadow-lg font-semibold border-l-4 border-orange-300' : 'hover:bg-blue-600/50' }} ">
                            <i class="w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3 text-sm">Ventas</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-3.5 text-white/90 hover:text-white rounded-xl transition-all duration-300 group {{ Route::is('dashboard') ? 'bg-orange-500/90 shadow-lg font-semibold border-l-4 border-orange-300' : 'hover:bg-blue-600/50' }} ">
                            <i class="w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3 text-sm">Administración de Caja</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-3.5 text-white/90 hover:text-white rounded-xl transition-all duration-300 group {{ Route::is('dashboard') ? 'bg-orange-500/90 shadow-lg font-semibold border-l-4 border-orange-300' : 'hover:bg-blue-600/50' }} ">
                            <i class="w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3 text-sm">Gestión de Servicios de Instalación</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-3.5 text-white/90 hover:text-white rounded-xl transition-all duration-300 group {{ Route::is('dashboard') ? 'bg-orange-500/90 shadow-lg font-semibold border-l-4 border-orange-300' : 'hover:bg-blue-600/50' }} ">
                            <i class="w-5 h-5 text-white transition duration-75"></i>
                            <span class="ml-3 text-sm">Reportes y Estadísticas</span>
                        </a>
                    </li>
                </ul>
                
                <!-- User Profile Section -->
                <div class="mt-8 sm:mt-10 pt-6 sm:pt-8 border-t border-blue-400 border-opacity-50">
                    <div class="flex items-center px-4 py-4 text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl group transition-all hover:from-blue-500 hover:to-blue-600">
                        <i class="text-2xl mr-3"></i>
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
        </nav>

        <!-- Main Content Area -->
        <div class="p-4 sm:ml-64">


            <!-- Page Content -->
            <main class="py-4">
                @yield('contenido')
            </main>
        </div>
    </div>
</body>
</html>