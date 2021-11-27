<?php

namespace Database\Seeders;

use App\Models\Drug;
use App\Models\DrugCategory;
use App\Models\DrugInformation;
use App\Models\DrugManufacturer;
use App\Models\DrugQtyLog;
use App\Models\DrugStorage;
use App\Models\User;
use App\Models\UserDoctorInformaion;
use App\Models\UserRole;
use App\Models\UserSupplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        UserRole::truncate();
        User::truncate();
        UserDoctorInformaion::truncate();
        UserSupplier::truncate();
        Drug::truncate();
        DrugInformation::truncate();
        DrugCategory::truncate();
        DrugManufacturer::truncate();
        DrugStorage::truncate();
        DrugQtyLog::truncate();

        $this->call([
            DrugCategorySeeder::class,
            DrugInformationSeeder::class,
            DrugManufacturerSeeder::class,
            DrugSeeder::class,
            DrugStorageSeeder::class,
            UserDoctorInformationSeeder::class,
            UserDoctorInformationSeeder::class,
            UserRoleSeeder::class,
            UserSupplierSeeder::class,
            DrugQtyLogSeeder::class,
        ]);

        User::create([
            'id' => 1,
            'first_name' => 'mr',
            'last_name' => 'super_admin',
            'user_name' => 'super_admin',
            'email' => 'super_admin@gmail.com',
            'role_serial' => 1,
            'password' => Hash::make('12345678'),

            'contact_number' => '+9342325323',
            'lat' => '22.820000',
            'lng' => '89.550003',
            'dob' => '1978-02-14',
            'street' => 'faruk road 14/A',
            'city' => 'dhaka',
            'country' => 'bangladesh',
            'state' => 'bangladesh',
            'zip_code' => '1414',
        ]);
        User::create([
            'id' => 2,
            'first_name' => 'mr',
            'last_name' => 'admin',
            'user_name' => 'admin',
            'email' => 'admin@gmail.com',
            'role_serial' => 2,
            'password' => Hash::make('12345678'),

            'contact_number' => '+9342325324',
            'lat' => '25.744860',
            'lng' => '89.275589',
            'dob' => '1978-02-14',
            'street' => 'faruk road 14/A',
            'city' => 'dhaka',
            'country' => 'bangladesh',
            'state' => 'bangladesh',
            'zip_code' => '1414',
        ]);
        User::create([
            'id' => 3,
            'first_name' => 'mr',
            'last_name' => 'doctor',
            'user_name' => 'doctor',
            'email' => 'doctor@gmail.com',
            'role_serial' => 3,
            'password' => Hash::make('12345678'),

            'contact_number' => '+9342325325',
            'lat' => '25.778522',
            'lng' => '88.897377',
            'dob' => '1978-02-14',
            'street' => 'faruk road 14/A',
            'city' => 'dhaka',
            'country' => 'bangladesh',
            'state' => 'bangladesh',
            'zip_code' => '1414',
        ]);
        User::create([
            'id' => 4,
            'first_name' => 'mr',
            'last_name' => 'pharmacy',
            'user_name' => 'pharmacy',
            'email' => 'pharmacy@gmail.com',
            'role_serial' => 4,
            'password' => Hash::make('12345678'),

            'contact_number' => '+9342325326',
            'lat' => '26.335377',
            'lng' => '88.551697',
            'dob' => '1978-02-14',
            'street' => 'faruk road 14/A',
            'city' => 'dhaka',
            'country' => 'bangladesh',
            'state' => 'bangladesh',
            'zip_code' => '1414',
        ]);
        User::create([
            'id' => 5,
            'first_name' => 'mr',
            'last_name' => 'consumer',
            'user_name' => 'consumer',
            'email' => 'consumer@gmail.com',
            'role_serial' => 5,
            'password' => Hash::make('12345678'),

            'contact_number' => '+9342325327',
            'lat' => '22.723406',
            'lng' => '89.075127',
            'dob' => '1978-02-14',
            'street' => 'faruk road 14/A',
            'city' => 'dhaka',
            'country' => 'bangladesh',
            'state' => 'bangladesh',
            'zip_code' => '1414',
        ]);
        User::create([
            'id' => 6,
            'first_name' => 'mr',
            'last_name' => 'delivery_man',
            'user_name' => 'delivery_man',
            'email' => 'delivery_man@gmail.com',
            'role_serial' => 6,
            'password' => Hash::make('12345678'),

            'contact_number' => '+9342325328',
            'lat' => '22.341900',
            'lng' => '91.815536',
            'dob' => '1978-02-14',
            'street' => 'faruk road 14/A',
            'city' => 'dhaka',
            'country' => 'bangladesh',
            'state' => 'bangladesh',
            'zip_code' => '1414',
        ]);
    }
}
