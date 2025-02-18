<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas web de la aplicación. Estas rutas son cargadas
| por el RouteServiceProvider y están dentro del grupo "web".
|
*/

// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas de autenticación (Login, Registro, Logout)
Auth::routes();

// Rutas para CLIENTES protegidas por middleware 'auth' y verificación de rol


Route::middleware(['auth', 'role:cliente'])->group(function () {
    Route::get('/profile', [ClienteController::class, 'profile'])->name('cliente.profile');
    Route::put('/profile/update', [ClienteController::class, 'updateProfile'])->name('cliente.update');
    Route::put('/profile/change-password', [ClienteController::class, 'updatePassword'])->name('cliente.password');
    Route::delete('/profile/delete', [ClienteController::class, 'destroy'])->name('cliente.delete');
});


// Rutas para ADMINISTRADORES protegidas por middleware 'auth' y verificación de rol
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/clientes', [AdminController::class, 'index'])->name('admin.clientes');
    Route::get('/admin/perfil', [AdminController::class, 'profile'])->name('admin.profile');
    Route::delete('/admin/clientes/{id}', [AdminController::class, 'destroyCliente'])->name('admin.clientes.destroy');
});

// Ruta Home (Redirección después de iniciar sesión)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
