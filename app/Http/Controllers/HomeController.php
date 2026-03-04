<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Chef;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Foodchef;
use App\Models\Category;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Página pública principal con paginación y categorías.
     */
    public function index()
    {
        // Paginamos para evitar cargar todo en memoria
        $foods = Food::with('category')->latest()->paginate(12);
        $chefs = Chef::all();
        $user = Auth::user();
        $count = $user ? Cart::where('user_id', $user->id)->count() : 0;
        $categories = Category::withCount('foods')->get();

        return view('home', compact('foods','chefs','count','categories'));
    }

    /**
     * Redirección después del login según rol/usertype.
     * Usa hasRole() si Spatie está configurado, sino usa usertype.
     */
    public function redirects(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('home');
        }

        // Preferir Spatie roles si existe el método
        if (method_exists($user, 'hasRole')) {
    if ($user->hasAnyRole(['admin','chef','mesero'])) {
        return redirect()->route('admin.dashboard');
    }
}
        // Fallback a usertype column
        switch ($user->usertype ?? null) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'chef':
                return redirect()->route('chef.dashboard');
            case 'mesero':
                return redirect()->route('mesero.dashboard');
            default:
                return redirect()->route('home');
        }
    }

    /**
     * Vista de menú completo (pública).
     */
    public function comidaview()
    {
        $foods = Food::with('category')->paginate(24);
        $user = Auth::user();
        $count = $user ? Cart::where('user_id', $user->id)->count() : 0;

        return view('comidaview', compact('foods','count'));
    }

    /**
     * Información de una comida (route-model binding).
     */
    public function infocomida(Food $food)
    {
        return view('infocomida', compact('food'));
    }

    /**
     * Actualizar estado de mesa (ej.: disponible, reservada, ocupada).
     * Se asume que la ruta está protegida por middleware (mesero/admin).
     */
    public function updateStatus(Request $request, Table $table)
    {
        $data = $request->validate([
            'status' => 'required|string|in:disponible,reservada,ocupada'
        ]);

        $table->update(['status' => $data['status']]);

        return redirect()->back()->with('success', 'Estado de la mesa actualizado correctamente.');
    }

    /**
     * Confirmar orden: crea Order + OrderItems en transacción.
     *
     * Formato esperado (recomendado):
     * items: [
     *   { food_id: 1, quantity: 2 },
     *   { food_id: 3, quantity: 1 },
     * ]
     *
     * También aceptamos el formato legacy (foodname[] + price[] + quantity[])
     */
    public function orderConfirm(Request $request)
    {
        // Primero validamos campos comunes
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:40',
            'address' => 'nullable|string',
        ]);

        $user = Auth::user();

        // Two possible payloads: 'items' structured or legacy arrays
        $items = $request->input('items');

        // Normalize items
        $normalized = [];

        if (is_array($items) && count($items) > 0) {
            // validate each item
            foreach ($items as $i => $it) {
                $validated = \Validator::make($it, [
                    'food_id' => 'required|exists:foods,id',
                    'quantity' => 'required|integer|min:1',
                ])->validate();

                $food = Food::find($validated['food_id']);
                $normalized[] = [
                    'food_id' => $food->id,
                    'title' => $food->title,
                    'price' => $food->price,
                    'quantity' => (int)$validated['quantity'],
                    'subtotal' => $food->price * (int)$validated['quantity'],
                ];
            }
        } else if ($request->has('foodname') && is_array($request->foodname)) {
            // legacy handling (arrays)
            $names = $request->foodname;
            $prices = $request->price ?? [];
            $qtys = $request->quantity ?? [];

            foreach ($names as $k => $name) {
                $price = isset($prices[$k]) ? floatval($prices[$k]) : 0;
                $qty = isset($qtys[$k]) ? intval($qtys[$k]) : 1;
                $normalized[] = [
                    'food_id' => null,
                    'title' => $name,
                    'price' => $price,
                    'quantity' => $qty,
                    'subtotal' => $price * $qty,
                ];
            }
        } else {
            return redirect()->back()->with('error', 'No se enviaron items para la orden.');
        }

        // Crear Order + OrderItems en transacción
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user ? $user->id : null,
                'customer_name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'total' => 0,
                'status' => 'pending',
            ]);

            $total = 0;
            foreach ($normalized as $it) {
                // Si existe food_id lo guardamos, sino guardamos title/price/texto
                $orderItem = $order->items()->create([
                    'food_id' => $it['food_id'] ?? null,
                    'title'   => $it['title'],
                    'price'   => $it['price'],
                    'quantity'=> $it['quantity'],
                    'subtotal'=> $it['subtotal'],
                ]);
                $total += $it['subtotal'];
            }

            $order->update(['total' => $total]);

            // Si el usuario autenticado tenía items en cart, eliminar los correspondientes
            if ($user) {
                $cartQuery = Cart::where('user_id', $user->id);
                // Si food_ids are available, delete those; otherwise empty cart
                $foodIds = array_filter(array_column($normalized, 'food_id'));
                if (count($foodIds) > 0) {
                    $cartQuery->whereIn('food_id', $foodIds)->delete();
                } else {
                    // legacy: delete all for simplicity (or customize)
                    $cartQuery->delete();
                }
            }

            DB::commit();
            return redirect()->route('home')->with('success', 'Orden creada correctamente. ID: ' . $order->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            // log error en producción (Log::error($e))
            return redirect()->back()->with('error', 'No se pudo procesar la orden. Intente de nuevo.');
        }
    }
}
