<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Vérifier si le rôle admin existe déjà
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Vérifier si l'admin existe déjà
        $admin = User::where('email', 'admin@gmail.com')->first();

        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'), // Change le mot de passe si nécessaire
            ]);
        }

        // Assigner le rôle admin à l'utilisateur
        $admin->assignRole($adminRole);

        // Ajouter les permissions nécessaires
        $permissions = [
            'create events',
            'edit events',
            'delete events',
            'view events',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assigner toutes les permissions au rôle admin
        $adminRole->syncPermissions($permissions);
    }
}
