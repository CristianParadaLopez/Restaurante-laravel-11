<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\ChefController;
use App\Http\Controllers\Admin\ChefProfileController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController as CustomerOrderController;
use Illuminate\Support\Facades\Route;

// ── Públicas ──────────────────────────────────────────────────
Route::get('/',            [HomeController::class, 'index'])->name('home');
Route::get('/menu',        [HomeController::class, 'comidaview'])->name('menu');
Route::get('/menu/{food}', [HomeController::class, 'infocomida'])->name('infocomida');

// ── Autenticado (cliente) ──────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/redirects', [HomeController::class, 'redirects'])->name('redirects');

    Route::get('/cart',           [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{food}',   [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::post('/order/confirm', [CustomerOrderController::class, 'confirm'])->name('order.confirm');
});

// ── Panel unificado ────────────────────────────────────────────
Route::prefix('admin')->name('admin.')
    ->middleware(['auth', 'role:admin,chef,mesero'])
    ->group(function () {

    // Dashboard — todos los roles
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Solo admin ──────────────────────────────────────────
    Route::middleware('role:admin')->group(function () {
        Route::resource('users',  UserController::class)->except('show')->names('users');
        Route::resource('chefs',  ChefController::class)->names('chefs');
        Route::resource('orders', OrderController::class)->only(['index','show'])->names('orders');
    });

    // ── Admin + Chef ────────────────────────────────────────
    Route::middleware('role:admin,chef')->group(function () {
        Route::resource('foods', FoodController::class)->names('foods');
    });

    // ── Solo Chef (su perfil) ────────────────────────────────
    Route::middleware('role:chef')->group(function () {
        Route::get('profile',       [ChefProfileController::class, 'index'])->name('profile.index');
        Route::post('profile',      [ChefProfileController::class, 'store'])->name('profile.store');
        Route::get('profile/edit',  [ChefProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile',       [ChefProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile',    [ChefProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // ── Admin + Mesero ───────────────────────────────────────
    Route::middleware('role:admin,mesero')->group(function () {
        Route::resource('tables', TableController::class)->names('tables');
        Route::post('tables/{table}/mark-as-used',
            [TableController::class, 'markAsUsed'])->name('tables.markAsUsed');

        Route::get('reservations',
            [ReservationController::class, 'index'])->name('reservations.index');
        Route::post('reservations',
            [ReservationController::class, 'store'])->name('reservations.store');
        Route::post('reservations/{reservation}/assign-table',
            [ReservationController::class, 'assignTable'])->name('reservations.assignTable');
        Route::delete('reservations/{reservation}',
            [ReservationController::class, 'destroy'])->name('reservations.destroy');
    });
    Route::fallback(function () {
    return redirect()->route('home');
});
});