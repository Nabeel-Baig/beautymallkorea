<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'name' => 'Beauty Mall Korea',
            'title' => 'Beauty Mall Korea',
            'logo' => '/images/logo.png',
            'footer_logo' => '/images/footerlogo.png',
            'favico' => '/images/logo.png',
            'email' => 'info@beautymallkorea.com',
            'phone' => '923333906233',
            'address' => 'Gulistan-e-Jauhar, Karachi.',
            'link' => 'beautymallkorea.com',
            'currency' => 'AED',
        ]);
    }
}
