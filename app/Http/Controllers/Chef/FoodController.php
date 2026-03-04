<?php

namespace App\Http\Controllers\Chef;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use App\Models\Category;
use App\Models\Food;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FoodController extends Controller
{
    protected ImageService $images;

    public function __construct(ImageService $images)
    {
        $this->images = $images;
        // Si quieres aplicar una autorización más fina:
        // $this->middleware('can:manage-own-foods')->only(['create','store','edit','update','destroy']);
    }

    /**
     * Mostrar listado de comidas para el chef.
     */
    public function index(): View
    {
        // El chef puede ver solo sus platillos si hay relación, por ahora mostramos todos paginados
        $foods = Food::with('category')->orderBy('created_at', 'desc')->paginate(12);
        $categories = Category::all();

        return view('chef.cheffoodmenu', compact('foods', 'categories'));
    }

    /**
     * Mostrar formulario de creación (opcional si usas modal en la vista).
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('chef.chefcreateview', compact('categories'));
    }

    /**
     * Almacenar nuevo menú (chef).
     */
    public function store(StoreFoodRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->store($request->file('image'), 'foods');
        }

        // Si quieres relacionar el food al chef, añade campo chef_id u otra lógica aquí
        Food::create($data);

        return redirect()->route('cheffoodmenu')->with('success', 'Menú agregado correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Food $food): View
    {
        $categories = Category::all();
        return view('chef.chefupdateview', compact('food', 'categories'));
    }

    /**
     * Actualizar comida.
     */
    public function update(UpdateFoodRequest $request, Food $food): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // eliminar imagen anterior si existe
            $this->images->delete($food->image);
            $data['image'] = $this->images->store($request->file('image'), 'foods');
        }

        $food->update($data);

        return redirect()->route('cheffoodmenu')->with('success', 'Menú actualizado correctamente.');
    }

    /**
     * Eliminar comida.
     */
    public function destroy(Food $food): RedirectResponse
    {
        $this->images->delete($food->image);
        $food->delete();

        return redirect()->back()->with('success', 'Menú eliminado correctamente.');
    }
}
