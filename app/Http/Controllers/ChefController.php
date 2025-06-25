<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chef;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class ChefController extends Controller
{
// Controlador de Chef:

// Función para ver los menús
public function cheffoodmenu() {
    $data = Food::all();
    $categories = Category::all();
    return view("chef.cheffoodmenu", compact("data", "categories"));
}

// Función para la vista de editar
public function chefupdateview($id) {
    $data = Food::find($id);
    $categories = Category::all(); // Obtener todas las categorías para el selector
    return view("chef.chefupdateview", compact("data", "categories"));
}

// Función para editar los menús
public function updatechef(Request $request, $id) {
    $data = Food::find($id);

    // Validación de los campos del formulario
    $request->validate([
        'title' => 'required|string|max:255',
        'price' => 'required|numeric',
        'description' => 'required|string',
        'ingredients' => 'nullable|string',
        'proteins' => 'nullable|string',
        'calories' => 'nullable|integer',
        'size' => 'nullable|string',
        'category_id' => 'nullable|exists:categories,id', // Validar que la categoría exista
        'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Validación de la imagen
    ]);

    // Actualizar los datos de la comida
    $data->title = $request->title;
    $data->price = $request->price;
    $data->description = $request->description;
    $data->ingredients = $request->ingredients;
    $data->proteins = $request->proteins;
    $data->calories = $request->calories;
    $data->size = $request->size;
    $data->category_id = $request->category_id;

    // Manejo de la imagen
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('foodimage'), $imagename);
        $data->image = $imagename;
    }

    // Guardar los cambios
    $data->save();

    return redirect()->route('cheffoodmenu');
}

// Función para ingresar datos al menú
public function uploadfoodchef(Request $request) {
    // Validación de los campos del formulario
    $request->validate([
        'title' => 'required|string|max:255',
        'price' => 'required|numeric',
        'description' => 'required|string',
        'ingredients' => 'nullable|string',
        'proteins' => 'nullable|string',
        'calories' => 'nullable|integer',
        'size' => 'nullable|string',
        'category_id' => 'nullable|exists:categories,id', // Validar que la categoría exista
        'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048', // Validación de la imagen
    ]);

    // Crear el nuevo registro de comida
    $data = new Food;
    $data->title = $request->title;
    $data->price = $request->price;
    $data->description = $request->description;
    $data->ingredients = $request->ingredients;
    $data->proteins = $request->proteins;
    $data->calories = $request->calories;
    $data->size = $request->size;
    $data->category_id = $request->category_id;

    // Manejo de la imagen
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('foodimage'), $imagename);
        $data->image = $imagename;
    }

    // Guardar el nuevo producto
    $data->save();

    return redirect('/cheffoodmenu');
}


    //Funcion para eliminar los menus
    public function chefdeletemenu($id){
        $data=Food::find($id);
        $data->delete();
        return redirect()->back();
    }
    
    
 // Mostrar el perfil del chef o el formulario de creación
 public function showProfile()
 {
     $user = Auth::user();

     // Verificar si el usuario es de tipo chef
     if ($user->usertype !== 'chef') {
         return redirect()->route('home')->with('error', 'No tienes permiso para acceder a esta página.');
     }

     // Obtener el perfil del chef asociado al usuario
     $chef = $user->chef;

     return view('chef.chefprofile', compact('chef'));
 }

 // Guardar los datos del perfil del chef
 public function storeProfile(Request $request)
 {
     $validated = $request->validate([
         'first_name' => 'required|string|max:255',
         'last_name' => 'required|string|max:255',
         'specialty' => 'required|string|max:255',
         'description' => 'nullable|string',
         'area' => 'required|in:preparacion,cocinar,servir,almacenamiento,lavar,pedidos',
         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
     ]);

     $user = Auth::user();

     // Crear el perfil si no existe
     $chef = new Chef();
     $chef->user_id = $user->id;
     $chef->first_name = $validated['first_name'];
     $chef->last_name = $validated['last_name'];
     $chef->specialty = $validated['specialty'];
     $chef->description = $validated['description'];
     $chef->area = $validated['area'];

     // Subir imagen
     if ($request->hasFile('image')) {
        $image = $request->image;
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('chefs'), $imageName);
        $chef->image = $imageName;
    }

     $chef->save();

     return redirect()->route('chef.profile')->with('success', 'Perfil creado con éxito.');
 }

 // Método para actualizar el perfil del chef
 public function updateProfile(Request $request)
 {
     $validated = $request->validate([
         'first_name' => 'required|string|max:255',
         'last_name' => 'required|string|max:255',
         'specialty' => 'required|string|max:255',
         'description' => 'nullable|string',
         'area' => 'required|in:preparacion,cocinar,servir,almacenamiento,lavar,pedidos',
         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
     ]);

     $chef = Auth::user()->chef;

     if (!$chef) {
         return redirect()->route('chef.profile')->with('error', 'No tienes un perfil de chef para editar.');
     }

     $chef->first_name = $validated['first_name'];
     $chef->last_name = $validated['last_name'];
     $chef->specialty = $validated['specialty'];
     $chef->description = $validated['description'];
     $chef->area = $validated['area'];

     // Subir nueva imagen si está presente
     if ($request->hasFile('image')) {
        $image = $request->image;
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('chefimage'), $imageName);
        $chef->image = $imageName;
    }

     $chef->save();

     return redirect()->route('chef.profile')->with('success', 'Perfil actualizado con éxito.');
 }
}