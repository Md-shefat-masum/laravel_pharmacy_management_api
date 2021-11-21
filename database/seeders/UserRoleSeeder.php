<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::create([
            'name' => 'super_admin',
            'role_serial' => 1,
        ]);
        UserRole::create([
            'name' => 'admin',
            'role_serial' => 2,
        ]);
        UserRole::create([
            'name' => 'doctor',
            'role_serial' => 3,
        ]);
        UserRole::create([
            'name' => 'pharmacy',
            'role_serial' => 4,
        ]);
        UserRole::create([
            'name' => 'consumer',
            'role_serial' => 5,
        ]);
        UserRole::create([
            'name' => 'delivery_man',
            'role_serial' => 6,
        ]);
    }
}
