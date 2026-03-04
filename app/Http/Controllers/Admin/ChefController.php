<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chef;
use App\Models\Foodchef;
use Illuminate\Http\Request;

class ChefController extends Controller
{
    public function index() {
        $chefs = Chef::all();
        $menus = Foodchef::all();
        return view('admin.chefs', compact('chefs','menus'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'=>'required|string|max:255',
            'speciality'=>'required|string|max:255',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $chef = new Foodchef();
        $chef->name = $request->name;
        $chef->speciality = $request->speciality;

        $image = $request->file('image');
        $filename = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('chefimage'), $filename);
        $chef->image = $filename;

        $chef->save();

        return redirect()->back()->with('success','Chef agregado correctamente');
    }

    public function edit($id) {
        $chef = Chef::findOrFail($id);
        return view('admin.editchef', compact('chef'));
    }

    public function update(Request $request, $id) {
        $chef = Chef::findOrFail($id);

        $chef->first_name = $request->first_name ?? $chef->first_name;
        $chef->last_name = $request->last_name ?? $chef->last_name;
        $chef->specialty = $request->specialty ?? $chef->specialty;
        $chef->description = $request->description ?? $chef->description;
        $chef->area = $request->area ?? $chef->area;

        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('chefimage'), $filename);
            $chef->image = $filename;
        }

        $chef->save();
        return redirect()->back()->with('success','Chef actualizado correctamente');
    }

    public function destroy($id) {
        $chef = Chef::findOrFail($id);
        $chef->delete();
        return redirect()->back()->with('success','Chef eliminado correctamente');
    }
}
