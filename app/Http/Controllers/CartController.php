<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Mostrar el carrito del usuario autenticado.
     */
    public function index(): View
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        // Asume relación user->cart() que hace belongsToMany o hasMany Cart::with('food')
        $items = Cart::with('food')
            ->where('user_id', $user->id)
            ->get();

        $count = $items->count();

        return view('showcart', [
            'items' => $items,
            'count' => $count,
        ]);
    }

    /**
     * Añadir/actualizar un item en el carrito.
     * Route example: POST /cart/{food}
     */
    public function store(Request $request, Food $food): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para añadir al carrito.');
        }

        // updateOrCreate para evitar duplicados
        Cart::updateOrCreate(
            ['user_id' => $user->id, 'food_id' => $food->id],
            ['quantity' => $request->input('quantity')]
        );

        return redirect()->back()->with('success', 'Producto agregado al carrito.');
    }

    /**
     * Eliminar un item del carrito.
     * Route example: DELETE /cart/{cart}
     */
    public function destroy(Cart $cart): RedirectResponse
    {
        $user = Auth::user();
        // Seguridad: solo el dueño puede eliminar
        if (! $user || $cart->user_id !== $user->id) {
            abort(403, 'No autorizado.');
        }

        $cart->delete();

        return redirect()->back()->with('success', 'Item eliminado del carrito.');
    }
}
