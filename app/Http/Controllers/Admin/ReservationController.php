<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('table')->orderBy('date','desc')->paginate(20);
        $tables = Table::where('status', 'disponible')->get();
        return view('admin.reservations', compact('reservations','tables'));
    }

    /**
     * Assign a table to reservation.
     */
    public function assignTable(Request $request, Reservation $reservation)
    {
        $data = $request->validate([
            'table_id' => 'required|exists:tables,id',
        ]);

        $table = Table::findOrFail($data['table_id']);

        // check seats
        if ((int)$reservation->guest !== (int)$table->seats) {
            return response()->json([
                'success' => false,
                'message' => 'El número de invitados no coincide con los asientos de la mesa.'
            ]);
        }

        DB::transaction(function () use ($reservation, $table) {
            $reservation->table_id = $table->id;
            $reservation->save();

            $table->status = 'reservada';
            $table->save();
        });

        return response()->json([
            'success' => true,
            'table_name' => $table->name,
            'user_name' => $reservation->name,
        ]);
    }
}
