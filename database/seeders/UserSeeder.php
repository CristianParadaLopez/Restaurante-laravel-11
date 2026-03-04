<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // 👈 Importamos el modelo de Spatie

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // =====================
        // 1️⃣ Crear roles
        // =====================
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $chefRole = Role::firstOrCreate(['name' => 'chef']);
        $meseroRole = Role::firstOrCreate(['name' => 'mesero']);

        // =====================
        // 2️⃣ Crear usuarios
        // =====================
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'usertype' => 'admin',
            'password' => Hash::make('admin1234'),
        ]);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'usertype' => 'user',
            'password' => Hash::make('user1234'),
        ]);

        $chef = User::create([
            'name' => 'Chef',
            'email' => 'chef@gmail.com',
            'usertype' => 'chef',
            'password' => Hash::make('chef1234'),
        ]);

        $mesero = User::create([
            'name' => 'Mesero',
            'email' => 'mesero@gmail.com',
            'usertype' => 'mesero',
            'password' => Hash::make('mesero1234'),
        ]);

        // =====================
        // 3️⃣ Asignar roles
        // =====================
        $admin->assignRole($adminRole);
        $user->assignRole($userRole);
        $chef->assignRole($chefRole);
        $mesero->assignRole($meseroRole);
    }
}
