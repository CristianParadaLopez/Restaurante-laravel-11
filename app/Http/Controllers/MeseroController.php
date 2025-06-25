<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;

class MeseroController extends Controller
{
    public function viewTables()
    {
        $tables = Table::all();
        return view('mesero.meseromesas', compact('tables'));
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
    
        return redirect()->route('meseromesas')->with('success', 'Mesa agregada correctamente.');
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

    return redirect()->route('meseromesas')->with('success', 'Mesa actualizada correctamente.');
}
    
    public function deleteTable($id)
    {
        $table = Table::findOrFail($id);
        $table->delete();
    
        return redirect()->route('meseromesas')->with('success', 'Mesa eliminada correctamente.');
    }
    public function meseroviewreservation()
    {
        // Obtener todas las reservaciones y las mesas disponibles
        $reservations = Reservation::with('table')->get();
        $tables = Table::where('status', 'disponible')->get();
    
        // Pasar las variables a la vista
        return view('mesero.meseroreservation', compact('reservations', 'tables'));
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
}
