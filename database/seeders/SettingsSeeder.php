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
            'logo' => 'images/logo.png',
            'footer_logo' => 'images/footerlogo.png',
            'favico' => 'images/favico.png',
            'email' => 'info@beautymallkorea.com',
            'phone' => '+92-333-3906233',
            'address' => '<ul>
						  <li>COMPANY : Barunson Co,. Ltd</li>
						  <li>LICENSE : 114-81-65451</li>
						  <li>ADDRESS : 16227 Yeongtong-gu Suwon-si Gyeonggi-do Korea 5th K-Tower Daehak 3-ro 1</li>
						  <li>D-U-N-S® Number : 694506164</li>
						</ul>',
            'link' => 'beautymallkorea.com',
            'currency' => 'Dhs',
        ]);
    }
}
