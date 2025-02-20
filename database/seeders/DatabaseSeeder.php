<?php

namespace Database\Seeders;

use App\Models\CarBrand;
use App\Models\CarType;
use App\Models\Fuel;
use App\Models\Paper;
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
            'login' => 'yelmalki',
            'nom' => 'el malki',
            'prenom' => 'yassine',
            'email' => 'yassine.elmalki@gmail.com',
        ]);
        Fuel::create(['label'=>'Diesel']);
        Paper::create(['label'=>'Carte grise']);
        Paper::create(['label'=>'Assurance']);
        Paper::create(['label'=>'Visite technique']);
        CarBrand::factory(4)->create();
        CarType::factory(2)->create();
    }
}
