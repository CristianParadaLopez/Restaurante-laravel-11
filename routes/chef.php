<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChefController;

Route::middleware(['auth', 'role:chef'])->prefix('chef')->group(function () {

    // Perfil
    Route::get('/profile', [ChefController::class, 'showProfile'])->name('chef.profile');
    Route::post('/profile', [ChefController::class, 'storeProfile'])->name('chef.profile.store');
    Route::post('/profile/update', [ChefController::class, 'updateProfile'])->name('chef.profile.update');

    // Menús
    Route::get('/menu', [ChefController::class, 'cheffoodmenu'])->name('chef.menu');
    Route::post('/menu', [ChefController::class, 'uploadfoodchef'])->name('chef.menu.store');
    Route::get('/menu/{id}/edit', [ChefController::class, 'chefupdateview'])->name('chef.menu.edit');
    Route::post('/menu/{id}', [ChefController::class, 'updatechef'])->name('chef.menu.update');
    Route::delete('/menu/{id}', [ChefController::class, 'chefdeletemenu'])->name('chef.menu.delete');
});
