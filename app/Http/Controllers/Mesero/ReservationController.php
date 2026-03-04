<?php

namespace App\Http\Controllers\Mesero;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Listar reservaciones (paginado).
     */
    public function index(Request $request)
    {
        $reservations = Reservation::with('table')->orderBy('date','desc')->paginate(20);
        $tables = Table::where('status','disponible')->get(); // para asignar en UI
        return view('mesero.meseroreservation', compact('reservations','tables'));
    }

    /**
     * Mostrar una reservación (opcional)
     */
    public function show(Reservation $reservation)
    {
        return view('mesero.reservation_show', compact('reservation'));
    }

    /**
     * Asignar mesa a reservación (AJAX/JSON).
     * Valida que el número de invitados coincida con asientos.
     */
    public function assignTable(Request $request, Reservation $reservation): JsonResponse
    {
        $data = $request->validate([
            'table_id' => 'required|exists:tables,id',
        ]);

        $table = Table::findOrFail($data['table_id']);

        // Verificación de disponibilidad
        if ($table->status !== 'disponible') {
            return response()->json([
                'success' => false,
                'message' => 'La mesa no está disponible para asignar.'
            ], 400);
        }

        // Verificar asientos
        if ((int)$reservation->guest !== (int)$table->seats) {
            return response()->json([
                'success' => false,
                'message' => 'El número de invitados no coincide con los asientos de la mesa.'
            ], 422);
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

    /**
     * Crear reservación (si permites que mesero cree).
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string|max:30',
            'guest' => 'required|integer|min:1',
            'date' => 'required|date',
            'time' => 'required',
            'message' => 'nullable|string',
        ]);

        Reservation::create($data);

        return redirect()->route('meseroreservation')->with('success', 'Reservación creada correctamente.');
    }

    /**
     * Cancelar o eliminar reservación.
     */
    public function destroy(Reservation $reservation): RedirectResponse
    {
        // Si la reservación tiene tabla asignada, libera la tabla
        if ($reservation->table) {
            $reservation->table->update(['status' => 'disponible']);
        }

        $reservation->delete();
        return redirect()->route('meseroreservation')->with('success', 'Reservación eliminada correctamente.');
    }
}
