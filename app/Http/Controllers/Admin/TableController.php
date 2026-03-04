<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::orderBy('number')->paginate(20);
        return view('admin.tables', compact('tables'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'number' => 'required|integer|unique:tables,number',
            'type'   => 'required|string|max:50',
            'seats'  => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        Table::create($data);

        return redirect()->route('admin.tables.index')->with('success', 'Mesa agregada correctamente.');
    }

    public function update(Request $request, Table $table)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'number' => 'required|integer|unique:tables,number,' . $table->id,
            'type'   => 'required|string|max:50',
            'seats'  => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        $table->update($data);

        return redirect()->route('admin.tables.index')->with('success', 'Mesa actualizada correctamente.');
    }

    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->route('admin.tables.index')->with('success', 'Mesa eliminada correctamente.');
    }

    /**
     * API: mark as used (shared route)
     */
    public function markAsUsed($id)
    {
        $table = Table::findOrFail($id);

        if ($table->status !== 'reservada') {
            return response()->json(['success' => false, 'message' => 'La mesa no está reservada.']);
        }

        // delete reservation (if relation exists)
        if (method_exists($table, 'reservation') && $table->reservation) {
            $table->reservation()->delete();
        }

        $table->update(['status' => 'disponible']);

        return response()->json(['success' => true, 'message' => 'Mesa marcada como utilizada.']);
    }
}
