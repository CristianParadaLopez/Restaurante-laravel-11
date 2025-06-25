<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chef;
use App\Models\Food;
use App\Models\Foodchef;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller
{
    public function user(){
        $data = User::all();
        return view("admin.users", compact("data"));
    }

    public function deleteuser($id){
        $data = User::find($id);
        $data->delete();
        return redirect()->back();
    }

    

    public function updateUser(Request $request, $id) {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->usertype = $request->usertype;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
    
        return redirect()->route('admin.user')->with('success', 'Usuario actualizado correctamente');
    }

    public function createUser(Request $request) {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'usertype' => $request->usertype,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('admin.user')->with('success', 'Usuario creado exitosamente');
    }

    //Funcion para ver los menus
    public function foodmenu(){
        $data= Food::all();
        $categories=Category::all();
        return view("admin.foodmenu",compact("data","categories"));
    }



// Función para la vista de editar
public function updateview($id) {
    $data = Food::find($id);
    $categories = Category::all();  // Agregar categorías disponibles para la vista
    return view("admin.updateview", compact("data", "categories"));
}

// Función para editar los menús
public function update(Request $request, $id) {
    $data = Food::find($id);
    
    if ($request->hasFile('image')) {
        $image = $request->image;
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $request->image->move('foodimage', $imagename);
        $data->image = $imagename;
    }

    $data->title = $request->title;
    $data->price = $request->price;
    $data->description = $request->description;
    $data->ingredients = $request->ingredients; // Ingredientes
    $data->proteins = $request->proteins; // Proteínas
    $data->calories = $request->calories; // Calorías
    $data->size = $request->size; // Tamaño
    $data->category_id = $request->category_id; // Relación con la categoría
   
    $data->save();
    
    return redirect()->route('foodmenu')->with('success', 'Menú agregado con éxito');
}

// Función para ingresar datos al menú
public function uploadfood(Request $request) {
    $data = new Food;

    if ($request->hasFile('image')) {
        $image = $request->image;
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $request->image->move('foodimage', $imagename);
        $data->image = $imagename;
    }

    $data->title = $request->title;
    $data->price = $request->price;
    $data->description = $request->description;
    $data->ingredients = $request->ingredients; // Ingredientes
    $data->proteins = $request->proteins; // Proteínas
    $data->calories = $request->calories; // Calorías
    $data->size = $request->size; // Tamaño
    $data->category_id = $request->category_id; // Relación con la categoría
    $data->save();

    return redirect()->route('foodmenu')->with('success', 'Menú agregado con éxito');
}


    //Funcion para eliminar los menus
    public function deletemenu($id){
        $data=Food::find($id);
        $data->delete();
        return redirect()->back();
    }
    
    //Función para ingresar las reservaciones 
    public function reservation(Request $request)
    {
        $data=new Reservation();
        $data->name=$request->name;
        $data->email=$request->email;
        $data->phone=$request->phone;
        $data->guest=$request->guest;
        $data->date=$request->date;
        $data->time=$request->time;
        $data->message=$request->message;
    
        $data->save();
        return redirect()->back();
        
    }
    // Para ver las reservaciones
public function viewreservation()
{
    // Obtener todas las reservaciones y las mesas disponibles
    $reservations = Reservation::with('table')->get();
    $tables = Table::where('status', 'disponible')->get();

    // Pasar las variables a la vista
    return view('admin.adminreservation', compact('reservations', 'tables'));
}


// Controlador para gestionar las reservaciones
public function assignTable(Request $request, $reservationId)
{
    $reservation = Reservation::findOrFail($reservationId);
    $table = Table::findOrFail($request->table_id);

    // Verificar si el número de invitados coincide con el número de asientos
    if ($reservation->guest == $table->seats) {
        // Asignar la mesa a la reservación
        $reservation->table_id = $table->id;
        $reservation->save();

        // Marcar la mesa como reservada
        $table->status = 'reservada';
        $table->save();

        return response()->json([
            'success' => true,
            'table_name' => $table->name,
            'user_name' => $reservation->name,
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'El número de invitados no coincide con los asientos de la mesa.',
        ]);
    }
}
 

//ver mesas 
    public function viewTables()
    {
        $tables = Table::all();
        return view('admin.adminmesas', compact('tables'));
    }
    
    public function storeTable(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|integer|unique:tables,number',
            'type' => 'required|string',
            'seats' => 'required|integer',
            'status' => 'required|string',
        ]);
    
        Table::create($request->all());
    
        return redirect()->route('adminmesas')->with('success', 'Mesa agregada correctamente.');
    }
    
    public function updateTable(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'number' => 'required|integer|unique:tables,number,' . $id,
        'type' => 'required|string',
        'seats' => 'required|integer',
        'status' => 'required|string|in:available,occupied,reservada',
    ]);

    $table = Table::findOrFail($id);

    // Asegúrate de actualizar campos individuales para evitar errores
    $table->name = $request->input('name');
    $table->number = $request->input('number');
    $table->type = $request->input('type');
    $table->seats = $request->input('seats');
    $table->status = $request->input('status');
    $table->save();

    return redirect()->route('adminmesas')->with('success', 'Mesa actualizada correctamente.');
}
    
    public function deleteTable($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();
    
        return redirect()->route('adminmesas')->with('success', 'Mesa eliminada correctamente.');
    }
    
    //Función para ver los chefs
    public function viewchef(){
        $data=Foodchef::all();
        $chefs=Chef::all();
        return view("admin.adminchef", compact('data','chefs'));
    }
    public function deleteChef($id)
    {
        $chef = Chef::find($id);
        if ($chef) {
            $chef->delete();
            return redirect()->back()->with('success', 'Chef eliminado correctamente.');
        }
        return redirect()->back()->with('error', 'Chef no encontrado.');
    }

    public function uploadchef(Request $request)
    {
        $data=new Foodchef();
        $image=$request->image;
        $imagename=time().''.$image->getClientOriginalExtension();
            $request->image->move('chefimage',$imagename);    
        $data->image=$imagename;

        $data->name=$request->name;
        $data->speciality=$request->speciality;
        $data->save();
        return redirect()->back();
    }


public function updateChef(Request $request, $id)
{
    $chef = Chef::find($id);
    if ($chef) {
        $chef->first_name = $request->input('first_name');
        $chef->last_name = $request->input('last_name');
        $chef->specialty = $request->input('specialty');
        $chef->description = $request->input('description');
        $chef->area = $request->input('area');
        
        if ($request->hasFile('image')) {
            // Si hay una nueva imagen, guardarla
            $path = $request->file('image')->store('chefs', 'public');
            $chef->image = $path;
        }
        
        $chef->save();
        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }
    return redirect()->back()->with('error', 'Chef no encontrado.');
}

    //Funcion para editar los menus
    public function updatefoodchef(Request $request , $id)
    {       
        $data=Foodchef::find($id);

        $image=$request->image;
        $imagename=time().''.$image->getClientOriginalExtension();
        $request->image->move('chefimage',$imagename);  
        $data->image=$imagename;  
        $data->name=$request->name;
        $data->speciality=$request->speciality;
       
        $image=$request->image;
   
     
        $data->save();
        return redirect()->back();
    }
    

    //Funcion para ver las ordenes
    public function orders(){
        $data=Order::all();
        return view('admin.orders',compact('data'));
    }
    //Funcion para ver las ordenes
    public function search(Request $request){
        $search=$request->search;
        $data=Order::where('name','Like','%'.$search.'%')->get();
        return view('admin.orders',compact('data'));
    }

    
}
