<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChefProfileRequest;
use App\Models\Chef;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected ImageService $images;

    public function __construct(ImageService $images)
    {
        $this->images = $images;
    }

    /**
     * Mostrar perfil del chef (si existe).
     */
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        // Redirigir si el usuario no es chef (extra seguridad)
        if ($user->usertype !== 'chef') {
            return redirect()->route('home')->with('error', 'No tienes permiso para acceder a esta página.');
        }

        $chefProfile = $user->chef; // relación hasOne definida en User::chef()
        return view('admin.chefprofile', compact('chefProfile'));
    }

    /**
     * Guardar perfil nuevo del chef.
     */
    public function store(ChefProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();

        // Evita crear múltiples perfiles si ya existe
        if ($user->chef) {
            return redirect()->route('admin.profile.index')->with('error', 'Ya tienes un perfil, usa editar para modificarlo.');
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->store($request->file('image'), 'chefs');
        }

        $chef = new Chef($data);
        $chef->user_id = $user->id;
        $chef->save();

        return redirect()->route('admin.profile.index')->with('success', 'Perfil creado con éxito.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user->chef) {
            return redirect()->route('admin.profile.index')->with('error', 'No tienes un perfil para editar.');
        }

        $chefProfile = $user->chef;
        return view('chef.chefprofileedit', compact('chefProfile'));
    }

    /**
     * Actualizar perfil del chef.
     */
    public function update(ChefProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $chef = $user->chef;

        if (! $chef) {
            return redirect()->route('admin.profile.index')->with('error', 'Perfil no encontrado.');
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->images->delete($chef->image);
            $data['image'] = $this->images->store($request->file('image'), 'chefs');
        }

        $chef->update($data);

        return redirect()->route('admin.profile.index')->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * (Opcional) Eliminar perfil del chef.
     */
    public function destroy(): RedirectResponse
    {
        $user = Auth::user();
        $chef = $user->chef;

        if ($chef) {
            $this->images->delete($chef->image);
            $chef->delete();
            return redirect()->route('home')->with('success', 'Perfil eliminado.');
        }

        return redirect()->route('admin.profile.index')->with('error', 'Perfil no encontrado.');
    }
}
