<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MeseroController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

Route::get("/",[HomeController::class,"index"]);
//Ruta para direccionar a los administradores y usuarios
Route::get("/redirects",[HomeController::class,"redirects"]);

//VISTAS COMIDAS
//ruta para seleccionar las comidas:
Route::get('/comidaview', [HomeController::class, 'comidaview'])->name('comidaview');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/infocomida/{id}', [HomeController::class, 'infocomida'])->name('infocomida');


// Ruta para mostrar la lista de usuarios
Route::get("/users", [AdminController::class, "user"])->name('admin.user');

// Ruta para eliminar un usuario
Route::delete("/deleteuser/{id}",[AdminController::class,"deleteuser"]);

// Ruta para mostrar el formulario de editar usuario y la acción de actualización
Route::post("/updateUser/{id}", [AdminController::class, "updateUser"])->name('updateUser');  // Para actualizar usuario

// Ruta para mostrar el formulario de crear usuario y la acción de creación
Route::post("/storeUser", [AdminController::class, "createUser"])->name('storeUser');  // Para crear usuario



//Ruta para ver los menus
Route::get("/foodmenu",[AdminController::class,"foodmenu"]);
//Ruta para ingresar datos al menu
Route::post("/uploadfood",[AdminController::class,"uploadfood"]);
//Ruta para eliminar los menus
Route::get("/deletemenu/{id}",[AdminController::class,"deletemenu"]);
//Ruta para editar los menus
Route::get("/updateview/{id}",[AdminController::class,"updateview"]);
Route::post("/update/{id}",[AdminController::class,"update"]);
Route::get('/foodmenu', [AdminController::class, 'foodmenu'])->name('foodmenu');
//cOMIDA
Route::get('/infocomida/{id}', [HomeController::class, 'infocomida'])->name('infocomida');


//Ruta para hacer la reservación
Route::post("/reservation",[AdminController::class,"reservation"]);
Route::get("/viewreservation",[AdminController::class,"viewreservation"]);

//Ruta para ver a los cefs
Route::get("/viewchef",[AdminController::class,"viewchef"]);
//Ruta para ingresar datos de los chefs
Route::post("/uploadchef",[AdminController::class,"uploadchef"]);
//Ruta para editar los chefs
Route::put("/updatechef/{id}",[AdminController::class,"updatechef"]);
Route::post("/updatefoodchef/{id}",[AdminController::class,"updatefoodchef"]);
//Ruta para eliminar los chefs
Route::delete("/deletechef/{id}",[AdminController::class,"deletechef"]);
//Ruta para eliminar los chefs
Route::post("/addcart/{id}",[HomeController::class,"addcart"]);

//Ruta para mostrar el carrito
Route::get("/showcart/{id}",[HomeController::class,"showcart"]);
//Ruta para eliminar item del carrito
Route::get("/remove/{id}",[HomeController::class,"remove"]);
//Ruta para enviar la orden 
Route::post("/orderconfirm",[HomeController::class,"orderconfirm"]);
//Ruta para ver las ordenes 
Route::get("/orders",[AdminController::class,"orders"]);

//Ruta para el buscador
Route::get("/search",[AdminController::class,"search"]);


//nUEVO
Route::get('/reservations', [AdminController::class, 'viewreservation'])->name('reservations');
// Route::post('/reservations/{reservation}/assign-table', [AdminController::class, 'assignTable'])->name('assign.table');
Route::post('/reservations/{reservationId}/assign-table', [AdminController::class, 'assignTable']);

Route::get('/adminmesas', [AdminController::class, 'viewTables'])->name('adminmesas');

// Ruta para almacenar una nueva mesa
Route::post('/adminmesas', [AdminController::class, 'storeTable']);

// Ruta para actualizar una mesa (desde el modal)
Route::put('/adminmesas/{id}', [AdminController::class, 'updateTable'])->name('adminmesasupdate');

// Ruta para eliminar una mesa
Route::delete('/adminmesas/{id}', [AdminController::class, 'deleteTable'])->name('adminmesasdelete');

Route::put('/adminmesas/{id}', [TableController::class, 'update'])->name('adminmesasupdate');

//ruta para marcarla mesa que se utilizo
Route::post('/tables/{id}/mark-as-used', [TableController::class, 'markAsUsed']);


//RUTA DE CHEFS:
// Rutas de perfil de chef
Route::get('/chefprofile', [ChefController::class, 'showProfile'])->name('chef.profile');
Route::post('/chefprofile/store', [ChefController::class, 'storeProfile'])->name('chef.profile.store');
Route::get('/chefprofile/edit', [ChefController::class, 'updateProfile'])->name('chef.profile.edit');
//Rutas de comida chef
Route::get("/cheffoodmenu", [ChefController::class, "cheffoodmenu"]);
//Ruta para ingresar datos al menu
Route::post("/uploadfoodchef",[ChefController::class,"uploadfoodchef"]);
//Ruta para eliminar los menus
Route::get("/chefdeletemenu/{id}",[ChefController::class,"chefdeletemenu"]);
//Ruta para editar los menus
Route::get("/chefupdateview/{id}",[ChefController::class,"chefupdateview"]);
Route::post("/updatechef/{id}",[ChefController::class,"updatechef"]);
Route::get('/cheffoodmenu', [ChefController::class, 'cheffoodmenu'])->name('cheffoodmenu');


//RUTAS DE MESEROS
//ruta para ver las mesas
Route::get('/meserohome', [HomeController::class, 'redirects'])->name('meserohome');

Route::get('/meseromesas', [MeseroController::class, 'viewTables'])->name('meseromesas');

// Ruta para almacenar una nueva mesa
Route::post('/meseromesas', [MeseroController::class, 'storeTable']);

// Ruta para actualizar una mesa (desde el modal)
Route::put('/meseromesas/{id}', [MeseroController::class, 'updateTable'])->name('meseromesasupdate');

// Ruta para eliminar una mesa
Route::delete('/meseromesas/{id}', [MeseroController::class, 'deleteTable'])->name('meseromesasdelete');

Route::post('/update-table-status', [HomeController::class, 'updateStatus'])->name('updateTableStatus');
Route::get('meseroreservation', [MeseroController::class, 'meseroviewreservation'])->name('meseroreservation');


Route::put('/meseromesas/{id}', [TableController::class, 'update'])->name('meseromesasupdate');

//ruta para marcarla mesa que se utilizo
Route::post('/tables/{id}/mark-as-used', [TableController::class, 'markAsUsed']);





Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});



