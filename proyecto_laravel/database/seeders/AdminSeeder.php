<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Administrador;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admins = [
            [
                'name' => 'Carlos',
                'email' => 'carlos@gmail.com',
                'password' => Hash::make('carlos1234'),
                'role' => 'admin'
            ],
            [
                'name' => 'Fernando',
                'email' => 'fernando@gmail.com',
                'password' => Hash::make('fernando1234'),
                'role' => 'admin'
            ]
        ];

        foreach ($admins as $adminData) {
            $user = User::create($adminData);

            Administrador::create([
                'user_id' => $user->id,
                'nombre' => $user->name, // Guardar el nombre en administradores
                'departamento' => 'Gerencia General'
            ]);
        }
    }
}
