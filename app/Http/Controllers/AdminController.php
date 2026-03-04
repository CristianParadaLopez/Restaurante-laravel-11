<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chef;
use App\Models\Food;
use App\Models\Foodchef;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ============================
    // Usuarios
    // ============================
    public function user()
    {
        $users = User::all();
        return view("admin.users", compact("users"));
    }

    public function deleteuser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Usuario eliminado correctamente.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->fill($request->only('name', 'email', 'usertype'));

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->route('admin.user')->with('success', 'Usuario actualizado correctamente.');
    }

    public function createUser(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'usertype' => $request->usertype,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.user')->with('success', 'Usuario creado exitosamente.');
    }

    // ============================
    // Menús
    // ============================
    public function foodmenu()
    {
        $foods = Food::all();
        $categories = Category::all();
        return view("admin.foodmenu", compact('foods', 'categories'));
    }

    public function uploadfood(Request $request)
    {
        $food = $this->saveFoodData(new Food(), $request);
        return redirect()->route('foodmenu')->with('success', 'Menú agregado con éxito.');
    }

    public function updateview($id)
    {
        $food = Food::findOrFail($id);
        $categories = Category::all();
        return view("admin.updateview", compact('food', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $food = Food::findOrFail($id);
        $this->saveFoodData($food, $request);
        return redirect()->route('foodmenu')->with('success', 'Menú actualizado con éxito.');
    }

    public function deletemenu($id)
    {
        Food::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Menú eliminado correctamente.');
    }

    // Función auxiliar para crear o actualizar menú
    protected function saveFoodData(Food $food, Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $food->image = time() . '.' . $image->getClientOriginalExtension();
            $image->move('foodimage', $food->image);
        }

        $food->fill($request->only([
            'title', 'price', 'description', 'ingredients', 'proteins', 'calories', 'size', 'category_id'
        ]));

        $food->save();
        return $food;
    }

    // ============================
    // Reservaciones
    // ============================
    public function reservation(Request $request)
    {
        Reservation::create($request->only('name', 'email', 'phone', 'guest', 'date', 'time', 'message'));
        return redirect()->back()->with('success', 'Reservación creada correctamente.');
    }

    public function viewreservation()
    {
        $reservations = Reservation::with('table')->get();
        $tables = Table::where('status', 'disponible')->get();
        return view('admin.adminreservation', compact('reservations', 'tables'));
    }

    public function assignTable(Request $request, $reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        $table = Table::findOrFail($request->table_id);

        if ($reservation->guest == $table->seats) {
            $reservation->table_id = $table->id;
            $reservation->save();

            $table->status = 'reservada';
            $table->save();

            return response()->json([
                'success' => true,
                'table_name' => $table->name,
                'user_name' => $reservation->name,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'El número de invitados no coincide con los asientos de la mesa.',
        ]);
    }

    // ============================
    // Mesas
    // ============================
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
        $table->fill($request->only('name', 'number', 'type', 'seats', 'status'));
        $table->save();

        return redirect()->route('adminmesas')->with('success', 'Mesa actualizada correctamente.');
    }

    public function deleteTable($id)
    {
        Table::findOrFail($id)->delete();
        return redirect()->route('adminmesas')->with('success', 'Mesa eliminada correctamente.');
    }

    // ============================
    // Chefs
    // ============================
    public function viewchef()
    {
        $foodchefs = Foodchef::all();
        $chefs = Chef::all();
        return view("admin.adminchef", compact('foodchefs','chefs'));
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
        $this->saveChefData(new Foodchef(), $request);
        return redirect()->back()->with('success', 'Chef agregado correctamente.');
    }

    public function updateChef(Request $request, $id)
    {
        $chef = Chef::findOrFail($id);
        if ($request->hasFile('image')) {
            $chef->image = $request->file('image')->store('chefs', 'public');
        }
        $chef->fill($request->only('first_name','last_name','specialty','description','area'));
        $chef->save();

        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatefoodchef(Request $request , $id)
    {
        $this->saveChefData(Foodchef::findOrFail($id), $request);
        return redirect()->back()->with('success', 'Chef actualizado correctamente.');
    }

    // Función auxiliar para crear o actualizar chefs
    protected function saveChefData($chef, Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move('chefimage', $imagename);
            $chef->image = $imagename;
        }

        $chef->fill($request->only('name','speciality'));
        $chef->save();
        return $chef;
    }

    // ============================
    // Ordenes
    // ============================
    public function orders()
    {
        $orders = Order::all();
        return view('admin.orders', compact('orders'));
    }

    public function search(Request $request)
    {
        $orders = Order::where('name','LIKE','%'.$request->search.'%')->get();
        return view('admin.orders', compact('orders'));
    }
}
