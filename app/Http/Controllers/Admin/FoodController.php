<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use App\Models\Category;
use App\Models\Food;
use App\Services\ImageService;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    protected ImageService $images;

    public function __construct(ImageService $images)
    {
        $this->images = $images;
    }

    /**
     * Display a listing of the foods.
     */
    public function index()
    {
        $foods = Food::with('category')->orderBy('id', 'desc')->paginate(12);
        $categories = Category::all();
        return view('admin.foods', compact('foods','categories'));
    }

    /**
     * Show create form (optional).
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.createfood', compact('categories'));
    }

    /**
     * Store a newly created food in storage.
     */
    public function store(StoreFoodRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->store($request->file('image'), 'foods');
        }

        Food::create($data);

        return redirect()->route('admin.foods.index')->with('success', 'Menú agregado con éxito.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Food $food)
    {
        $categories = Category::all();
        return view('admin.updateview', compact('food','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodRequest $request, Food $food)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // delete old image
            $this->images->delete($food->image);
            $data['image'] = $this->images->store($request->file('image'), 'foods');
        }

        $food->update($data);

        return redirect()->route('admin.foods.index')->with('success', 'Menú actualizado con éxito.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food)
    {
        // delete image
        $this->images->delete($food->image);
        $food->delete();

        return redirect()->back()->with('success', 'Menú eliminado correctamente.');
    }
}
