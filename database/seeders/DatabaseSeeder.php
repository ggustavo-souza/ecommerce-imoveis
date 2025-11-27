<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@loja.com',
            'password' => bcrypt('senha123'), // Senha para login
            'is_admin' => true, // Define como Admin
        ]);

    User::factory()->create([
            'name' => 'usuario',
            'email' => 'usuario@usuario.com',
            'password' => bcrypt('usuario'),
            'is_admin' => false,
        ]);
    }
}
