<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keys = ['Président','Vice Président','Le responsable de Parc'];
        foreach ($keys as $key) {
            Setting::create([
                'key' => $key,
                'value' => $key
            ]);
        }

    }
}
