<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TableController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Usuarios
    Route::get('/users', [AdminController::class, 'user'])->name('admin.users');
    Route::post('/users', [AdminController::class, 'createUser'])->name('admin.users.store');
    Route::post('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteuser'])->name('admin.users.delete');

    // Menú
    Route::get('/foodmenu', [AdminController::class, 'foodmenu'])->name('admin.foodmenu');
    Route::post('/foodmenu', [AdminController::class, 'uploadfood'])->name('admin.foodmenu.store');
    Route::get('/foodmenu/{id}/edit', [AdminController::class, 'updateview'])->name('admin.foodmenu.edit');
    Route::post('/foodmenu/{id}', [AdminController::class, 'update'])->name('admin.foodmenu.update');
    Route::delete('/foodmenu/{id}', [AdminController::class, 'deletemenu'])->name('admin.foodmenu.delete');

    // Chefs
    Route::get('/chefs', [AdminController::class, 'viewchef'])->name('admin.chefs');
    Route::post('/chefs', [AdminController::class, 'uploadchef'])->name('admin.chefs.store');
    Route::put('/chefs/{id}', [AdminController::class, 'updatechef'])->name('admin.chefs.update');
    Route::delete('/chefs/{id}', [AdminController::class, 'deletechef'])->name('admin.chefs.delete');

    // Reservaciones
    Route::get('/reservations', [AdminController::class, 'viewreservation'])->name('admin.reservations');
    Route::post('/reservations/{reservationId}/assign-table', [AdminController::class, 'assignTable'])->name('admin.reservations.assign');

    // Mesas
    Route::get('/tables', [TableController::class, 'index'])->name('admin.tables');
    Route::post('/tables', [TableController::class, 'store'])->name('admin.tables.store');
    Route::put('/tables/{id}', [TableController::class, 'update'])->name('admin.tables.update');
    Route::delete('/tables/{id}', [TableController::class, 'destroy'])->name('admin.tables.delete');
    Route::post('/tables/{id}/mark-as-used', [TableController::class, 'markAsUsed'])->name('admin.tables.used');

    // Órdenes
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/search', [AdminController::class, 'search'])->name('admin.orders.search');
});
