<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chef;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChefController extends Controller
{
    // ============================
    // Menús de chef
    // ============================

    public function cheffoodmenu()
    {
        $foods = Food::all();
        $categories = Category::all();
        return view("chef.cheffoodmenu", compact('foods', 'categories'));
    }

    public function chefupdateview($id)
    {
        $food = Food::findOrFail($id);
        $categories = Category::all();
        return view("chef.chefupdateview", compact('food', 'categories'));
    }

    public function updatechef(Request $request, $id)
    {
        $food = Food::findOrFail($id);
        $this->saveFood($food, $request);
        return redirect()->route('cheffoodmenu')->with('success', 'Menú actualizado correctamente.');
    }

    public function uploadfoodchef(Request $request)
    {
        $food = new Food();
        $this->saveFood($food, $request);
        return redirect()->route('cheffoodmenu')->with('success', 'Menú agregado correctamente.');
    }

    public function chefdeletemenu($id)
    {
        Food::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Menú eliminado correctamente.');
    }

    // Función auxiliar para crear o actualizar comida
    protected function saveFood(Food $food, Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'ingredients' => 'nullable|string',
            'proteins' => 'nullable|string',
            'calories' => 'nullable|integer',
            'size' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $food->fill($validated);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('foodimage'), $imageName);
            $food->image = $imageName;
        }

        $food->save();
    }

    // ============================
    // Perfil de chef
    // ============================

    public function showProfile()
    {
        $user = Auth::user();
        if ($user->usertype !== 'chef') {
            return redirect()->route('home')->with('error', 'No tienes permiso para acceder a esta página.');
        }

        $chefProfile = $user->chef;
        return view('chef.chefprofile', compact('chefProfile'));
    }

    public function storeProfile(Request $request)
    {
        $chef = new Chef();
        $this->saveChefProfile($chef, $request);
        $chef->user_id = Auth::id();
        $chef->save();

        return redirect()->route('chef.profile')->with('success', 'Perfil creado con éxito.');
    }

    public function updateProfile(Request $request)
    {
        $chef = Auth::user()->chef;

        if (!$chef) {
            return redirect()->route('chef.profile')->with('error', 'No tienes un perfil de chef para editar.');
        }

        $this->saveChefProfile($chef, $request);

        return redirect()->route('chef.profile')->with('success', 'Perfil actualizado con éxito.');
    }

    // Función auxiliar para crear o actualizar perfil de chef
    protected function saveChefProfile(Chef $chef, Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'description' => 'nullable|string',
            'area' => 'required|in:preparacion,cocinar,servir,almacenamiento,lavar,pedidos',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $chef->fill($validated);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('chefimage'), $imageName);
            $chef->image = $imageName;
        }

        $chef->save();
    }
}
