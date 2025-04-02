<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Vérifier si l'admin existe déjà
        $admin = User::where('email', 'admin@gmail.com')->first();

        if (!$admin) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'), // Change le mot de passe si nécessaire
                'role' => 'admin',
            ]);
        }
    }
}
