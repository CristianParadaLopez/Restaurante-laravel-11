<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::all();
        return view('admin.adminmesas', compact('tables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|unique:tables,number',
            'type' => 'required|in:terraza,interior,exterior',
            'status' => 'required|in:available,occupied,reserved',
            'seats' => 'required|integer|min:1',
        ]);

        Table::create($request->all());
        return redirect()->route('adminmesas')->with('success', 'Mesa creada correctamente.');
    }

    public function update(Request $request, $id)
{
    $table = Table::findOrFail($id);

    $table->update([
        'name' => $request->input('name'),
        'number' => $request->input('number'),
        'type' => $request->input('type'),
        'status' => $request->input('status'),
        'seats' => $request->input('seats'),
    ]);

    return redirect()->route('adminmesas')->with('success', 'Mesa actualizada correctamente');

}


    public function destroy($id)
    {
        Table::findOrFail($id)->delete();
        return redirect()->route('adminmesas')->with('success', 'Mesa eliminada correctamente.');
    }

    public function markAsUsed($id)
{
    $table = Table::findOrFail($id);

    // Verifica que la mesa esté reservada
    if ($table->status !== 'reservada') {
        return response()->json(['success' => false, 'message' => 'La mesa no está reservada.']);
    }

    // Elimina la reservación y actualiza el estado de la mesa
    $table->reservation()->delete();
    $table->update(['status' => 'disponible']);

    return response()->json(['success' => true, 'message' => 'Mesa marcada como utilizada.']);
}
}
