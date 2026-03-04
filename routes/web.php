<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\FoodController as AdminFoodController;
use App\Http\Controllers\Admin\TableController as AdminTableController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ChefController as AdminChefController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

use App\Http\Controllers\Chef\FoodController as ChefFoodController;
use App\Http\Controllers\Chef\ProfileController as ChefProfileController;

use App\Http\Controllers\Mesero\DashboardController as MeseroDashboardController;
use App\Http\Controllers\Mesero\TableController as MeseroTableController;
use App\Http\Controllers\Mesero\ReservationController as MeseroReservationController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS / HOME
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/redirects', [HomeController::class, 'redirects'])->middleware('auth')->name('redirects');
Route::get('/comidaview', [HomeController::class, 'comidaview'])->name('comidaview');
Route::get('/menu', [HomeController::class, 'comidaview'])->name('menu');
Route::get('/infocomida/{food}', [HomeController::class, 'infocomida'])->name('infocomida');

/*
|--------------------------------------------------------------------------
| RUTAS AUTH (CARRITO + ORDENES)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{food}', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::post('/orderconfirm', [HomeController::class, 'orderConfirm'])->name('order.confirm');
});

/*
|--------------------------------------------------------------------------
| RUTAS ADMIN PANEL UNIFICADO
|--------------------------------------------------------------------------
| Aquí todos los roles que pueden acceder al panel: admin, chef, mesero
| Usamos RoleMiddleware mejorado que soporta múltiples roles
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')
    ->middleware(['auth','role:admin,chef,mesero'])
    ->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN: Usuarios (solo admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', AdminUserController::class)->except(['show'])->names('users');
        Route::resource('chefs', AdminChefController::class)->names('chefs');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN / CHEF: Menus de comida
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,chef')->group(function () {
        Route::resource('foods', AdminFoodController::class)->names('foods');
    });

    /*
    |--------------------------------------------------------------------------
    | MESERO / ADMIN: Mesas
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,mesero')->group(function () {
        Route::resource('tables', AdminTableController::class)->names('tables');
        Route::post('tables/{table}/mark-as-used', [AdminTableController::class, 'markAsUsed'])->name('tables.markAsUsed');
    });

    /*
    |--------------------------------------------------------------------------
    | MESERO / ADMIN: Reservaciones
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,mesero')->group(function () {
        Route::get('reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
        Route::post('reservations/{reservation}/assign-table', [AdminReservationController::class, 'assignTable'])->name('reservations.assignTable');
        Route::delete('reservations/{reservation}', [AdminReservationController::class, 'destroy'])->name('reservations.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN: Ordenes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    });

    /*
    |--------------------------------------------------------------------------
    | CHEF: Perfil propio
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,chef')->group(function () {
        Route::get('profile', [AdminProfileController::class, 'index'])->name('profile.index');
        Route::post('profile', [AdminProfileController::class, 'store'])->name('profile.store');
        Route::get('profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| DASHBOARD JETSTREAM / SANCTUM
|--------------------------------------------------------------------------
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
