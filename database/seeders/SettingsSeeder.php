<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Settings::create(['key' => 'logo', 'value' => 'assets/logo/logo.png']);
        Settings::create(['key' => 'email', 'value' => 'admin@example.com']);
        Settings::create(['key' => 'favicon', 'value' => 'favicon.ico']);
    }
}
