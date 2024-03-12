<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
       // $this->call(RolesSeeder::class);
        $this->call(VolumenesTableSeeder::class);
        $this->call(DivisionesTableSeeder::class);
        $this->call(LibrosTableSeeder::class);
        $this->call(PartesTableSeeder::class);
        $this->call(CapitulosTableSeeder::class);
        $this->call(PericopasTableSeeder::class);
        $this->call(VersiculosTableSeeder::class);
        $this->call(VersiculosComentariosTableSeeder::class);

    }
}
