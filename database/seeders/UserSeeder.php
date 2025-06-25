<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'usertype' => 'admin', 
            'password' => Hash::make('admin1234'),
        ]);

        // Crear usuario estándar
        User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'usertype' => 'user',
            'password' => Hash::make('user1234'),
        ]);
        User::create([
            'name' => 'Chef',
            'email' => 'chef@gmail.com',
            'usertype' => 'chef',
            'password' => Hash::make('chef1234'),
        ]);
        User::create([
            'name' => 'Mesero',
            'email' => 'mesero@gmail.com',
            'usertype' => 'mesero',
            'password' => Hash::make('mesero1234'),
        ]);
    }
}
