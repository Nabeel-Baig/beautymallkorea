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
            'name' => 'Start Fundraising',
            'title' => 'Start Fundraising',
            'logo' => '/assets/uploads/settings/IUiCWdBDtVeeJ7cNf9oe5QWCUgPW8bhaGpEMLfeh.png',
            'favico' => '/assets/uploads/settings/pHyip36xXyByrHb3DhZjfOPlqvEc55PxlsUhJy32.png',
            'email' => 'info@fundraising.com',
            'phone' => '923333906233',
            'address' => 'Gulistan-e-Jauhar, Karachi.',
            'link' => 'outsourcetoasia.io',
        ]);
    }
}
