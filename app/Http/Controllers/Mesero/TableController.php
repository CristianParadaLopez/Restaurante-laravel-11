<?php

namespace App\Http\Controllers\Mesero;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TableController extends Controller
{
    /**
     * Mostrar las mesas asignadas al mesero / o todas si corresponde.
     */
    public function index(Request $request)
    {
        // Si más adelante quieres filtrar por sede/area, agrega filtros aquí
        $tables = Table::orderBy('number')->paginate(20);
        return view('mesero.meseromesas', compact('tables'));
    }

    /**
     * Crear una mesa (mesero puede crear según tus reglas).
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'number' => 'required|integer|unique:tables,number',
            'type'   => 'required|string|max:50',
            'seats'  => 'required|integer|min:1',
            'status' => 'required|string|in:disponible,reservada,ocupada',
        ]);

        Table::create($data);

        return redirect()->route('meseromesas')->with('success', 'Mesa agregada correctamente.');
    }

    /**
     * Actualizar mesa.
     */
    public function update(Request $request, Table $table): RedirectResponse
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'number' => 'required|integer|unique:tables,number,' . $table->id,
            'type'   => 'required|string|max:50',
            'seats'  => 'required|integer|min:1',
            'status' => 'required|string|in:disponible,reservada,ocupada',
        ]);

        $table->update($data);

        return redirect()->route('meseromesas')->with('success', 'Mesa actualizada correctamente.');
    }

    /**
     * Eliminar mesa.
     */
    public function destroy(Table $table): RedirectResponse
    {
        $table->delete();
        return redirect()->route('meseromesas')->with('success', 'Mesa eliminada correctamente.');
    }

    /**
     * API / AJAX — marcar mesa como usada (ej: finalizar reservación).
     * Retorna JSON.
     */
    public function markAsUsed(Table $table): JsonResponse
    {
        if ($table->status !== 'reservada') {
            return response()->json(['success' => false, 'message' => 'La mesa no está reservada.'], 400);
        }

        // Si la mesa tiene relación reservation(), elimina la reserva
        if (method_exists($table, 'reservation') && $table->reservation) {
            $table->reservation()->delete();
        }

        $table->update(['status' => 'disponible']);

        return response()->json(['success' => true, 'message' => 'Mesa marcada como utilizada.']);
    }
}
