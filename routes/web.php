<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlmacenistaController;
use App\Http\Controllers\CajeroController;
use App\Http\Controllers\InstaladorController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\ProvidersController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    if (Auth::user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->hasRole('almacenista')) {
        return redirect()->route('almacenista.dashboard');
    } elseif (Auth::user()->hasRole('cajero')) {
        return redirect()->route('cajero.dashboard');
    } else {
        return redirect()->route('instalador.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

//Grupo de rutas para usuario Administrador
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');


    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');


    // Rutas de gestión de productos
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{producto}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::patch('/admin/products/{producto}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{producto}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // Rutas de gestión de categorías
    Route::get('/admin/categorias', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('/admin/categorias/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/categorias', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/admin/categorias/{categoria}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::patch('/admin/categorias/{categoria}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/admin/categorias/{categoria}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');

    // Rutas de gestión de stock
    Route::get('/admin/stock', [StockController::class, 'index'])->name('admin.stock.index');
    Route::get('/admin/stock/create', [StockController::class, 'create'])->name('admin.stock.create');
    Route::post('/admin/stock', [StockController::class, 'store'])->name('admin.stock.store');
    Route::get('/admin/stock/{stock}/edit', [StockController::class, 'edit'])->name('admin.stock.edit');
    Route::patch('/admin/stock/{stock}', [StockController::class, 'update'])->name('admin.stock.update');
    Route::delete('/admin/stock/{stock}', [StockController::class, 'destroy'])->name('admin.stock.destroy');

    // Rutas de gestión de proveedores
    Route::get('/admin/providers', [ProvidersController::class, 'index'])->name('admin.providers.index');
    Route::get('/admin/providers/create', [ProvidersController::class, 'create'])->name('admin.providers.create');
    Route::post('/admin/providers', [ProvidersController::class, 'store'])->name('admin.providers.store');
    Route::get('/admin/providers/{proveedor}/edit', [ProvidersController::class, 'edit'])->name('admin.providers.edit');
    Route::patch('/admin/providers/{proveedor}', [ProvidersController::class, 'update'])->name('admin.providers.update');
    Route::delete('/admin/providers/{proveedor}', [ProvidersController::class, 'destroy'])->name('admin.providers.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/almacenista/dashboard', [AlmacenistaController::class, 'index'])->name('almacenista.dashboard');

    Route::get('/cajero/dashboard', [CajeroController::class, 'index'])->name('cajero.dashboard');

    Route::get('/instalador/dashboard', [InstaladorController::class, 'index'])->name('instalador.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';