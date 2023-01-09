<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id'         => 1,
                'title'      => 'Master Admin',
                'created_at' => '2019-09-27 07:11:07',
                'updated_at' => '2019-09-27 07:11:07',
            ],
            [
                'id'         => 2,
                'title'      => 'Admin',
                'created_at' => '2019-09-27 07:11:07',
                'updated_at' => '2019-09-27 07:11:07',
            ],
            [
                'id'         => 3,
                'title'      => 'User',
                'created_at' => '2019-09-27 07:11:07',
                'updated_at' => '2019-09-27 07:11:07',
            ]
        ];

        Role::insert($roles);
    }
}
