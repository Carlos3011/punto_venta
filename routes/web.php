<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlmacenistaController;
use App\Http\Controllers\CajeroController;
use App\Http\Controllers\InstaladorController;

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

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