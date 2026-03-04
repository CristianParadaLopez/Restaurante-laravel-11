<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeseroController;
use App\Http\Controllers\TableController;

Route::middleware(['auth', 'role:mesero'])->prefix('mesero')->group(function () {

    Route::get('/home', fn() => view('mesero.meserohome'))->name('mesero.home');

    // Mesas
    Route::get('/tables', [MeseroController::class, 'viewTables'])->name('mesero.tables');
    Route::post('/tables', [MeseroController::class, 'storeTable'])->name('mesero.tables.store');
    Route::put('/tables/{id}', [MeseroController::class, 'updateTable'])->name('mesero.tables.update');
    Route::delete('/tables/{id}', [MeseroController::class, 'deleteTable'])->name('mesero.tables.delete');

    // Reservaciones
    Route::get('/reservations', [MeseroController::class, 'meseroviewreservation'])->name('mesero.reservations');
    Route::post('/reservations/{reservationId}/assign-table', [MeseroController::class, 'assignTable'])->name('mesero.reservations.assign');

    // Marcar mesa como usada
    Route::post('/tables/{id}/mark-as-used', [TableController::class, 'markAsUsed'])->name('mesero.tables.used');
});
