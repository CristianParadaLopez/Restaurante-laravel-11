<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * List users (paginated).
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(20);
        return view('admin.users', compact('users'));
    }

    /**
     * Store new user.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'usertype' => 'required|string|in:admin,chef,mesero,user',
            'role'     => 'nullable|string' // optional if using Spatie roles
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'usertype' => $data['usertype'] ?? 'user',
        ]);

        // If you use Spatie roles and front sends 'role'
        if (!empty($data['role']) && method_exists($user, 'assignRole')) {
            $user->syncRoles([$data['role']]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Update user.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'usertype' => 'required|string|in:admin,chef,mesero,user',
            'role'     => 'nullable|string'
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->usertype = $data['usertype'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        if (isset($data['role']) && method_exists($user, 'syncRoles')) {
            $user->syncRoles([$data['role']]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Delete user.
     */
    public function destroy(User $user)
    {
        // You might want to prevent deleting yourself:
        // if (auth()->id() === $user->id) { ... }

        $user->delete();
        return redirect()->back()->with('success', 'Usuario eliminado correctamente.');
    }
}
