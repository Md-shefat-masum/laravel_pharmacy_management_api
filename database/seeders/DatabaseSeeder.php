<?php

namespace Database\Seeders;

use App\Models\DoctorAppoinment;
use App\Models\DoctorPrescription;
use App\Models\DoctorPrescriptionInvestigation;
use App\Models\DoctorPrescriptionMedicine;
use App\Models\DoctorSpeciality;
use App\Models\Drug;
use App\Models\DrugCategory;
use App\Models\DrugInformation;
use App\Models\DrugManufacturer;
use App\Models\DrugQtyLog;
use App\Models\DrugStorage;
use App\Models\Order;
use App\Models\OrderBillingAddress;
use App\Models\OrderDetails;
use App\Models\OrderPayment;
use App\Models\OrderPrescriptionImage;
use App\Models\OrderSalesLog;
use App\Models\OrderShippingAddress;
use App\Models\User;
use App\Models\UserDoctorInformaion;
use App\Models\UserRole;
use App\Models\UserSupplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        Order::truncate();
        OrderDetails::truncate();
        OrderPayment::truncate();
        OrderSalesLog::truncate();
        OrderPrescriptionImage::truncate();
        OrderBillingAddress::truncate();
        OrderShippingAddress::truncate();
        DoctorSpeciality::truncate();
        DoctorAppoinment::truncate();
        DoctorPrescription::truncate();
        DoctorPrescriptionMedicine::truncate();
        DoctorPrescriptionInvestigation::truncate();
        DB::table('doctor_speciality_user')->truncate();

        $this->call([
            DoctorSeeder::class,
            DrugCategorySeeder::class,
            DrugInformationSeeder::class,
            DrugManufacturerSeeder::class,
            DrugSeeder::class,
            DrugStorageSeeder::class,
            UserDoctorInformationSeeder::class,
            UserRoleSeeder::class,
            UserSupplierSeeder::class,
            DrugQtyLogSeeder::class,
            OrderSeeder::class,
            DoctorAppoinmentSeeder::class,
            DoctorPrescriptionSeeder::class,
        ]);

        User::create([
            'id' => 1,
            'user_code' => rand(100000, 999999) . '1',
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
            'gender' => 'male',
            'street' => 'faruk road 14/A',
            'city' => 'dhaka',
            'country' => 'bangladesh',
            'state' => 'bangladesh',
            'zip_code' => '1414',
        ]);

        User::create([
            'id' => 2,
            'user_code' => rand(100000, 999999) . '2',
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
            'gender' => 'male',
            'street' => 'faruk road 14/A',
            'city' => 'dhaka',
            'country' => 'bangladesh',
            'state' => 'bangladesh',
            'zip_code' => '1414',
        ]);

        User::create([
            'id' => 3,
            'user_code' => rand(100000, 999999) . '3',
            'first_name' => 'mr',
            'last_name' => 'doctor',
            'user_name' => 'doctor',
            'email' => 'doctor@gmail.com',
            'role_serial' => 3,
            'password' => Hash::make('12345678'),

            'contact_number' => '+9342325325',
            'lat' => '23.71557',
            'lng' => '90.432785',
            'dob' => '1978-02-14',
            'gender' => 'male',
            'street' => 'faruk road 14/A',
            'city' => 'dhaka',
            'country' => 'bangladesh',
            'state' => 'bangladesh',
            'zip_code' => '1414',
        ]);

        User::create([
            'id' => 4,
            'user_code' => rand(100000, 999999) . '4',
            'first_name' => 'mr',
            'last_name' => 'pharmacy',
            'user_name' => 'pharmacy',
            'email' => 'pharmacy@gmail.com',
            'role_serial' => 4,
            'password' => Hash::make('12345678'),

            'contact_number' => '+9342325326',
            'lat' => '23.71557',
            'lng' => '90.432785',
            'dob' => '1978-02-14',
            'gender' => 'male',
            'street' => 'faruk road 14/A',
            'city' => 'dhaka',
            'country' => 'bangladesh',
            'state' => 'bangladesh',
            'zip_code' => '1414',
        ]);

        User::create([
            'id' => 5,
            'user_code' => rand(100000, 999999) . '5',
            'first_name' => 'mr',
            'last_name' => 'consumer',
            'user_name' => 'consumer',
            'email' => 'consumer@gmail.com',
            'role_serial' => 5,
            'password' => Hash::make('12345678'),

            'contact_number' => '+9342325327',
            'lat' => '23.708981',
            'lng' => '90.436921',
            'dob' => '1978-02-14',
            'gender' => 'male',
            'street' => 'faruk road 14/A',
            'city' => 'dhaka',
            'country' => 'bangladesh',
            'state' => 'bangladesh',
            'zip_code' => '1414',
        ]);

        User::create([
            'id' => 6,
            'user_code' => rand(100000, 999999) . '6',
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
            'gender' => 'male',
            'street' => 'faruk road 14/A',
            'city' => 'dhaka',
            'country' => 'bangladesh',
            'state' => 'bangladesh',
            'zip_code' => '1414',
        ]);

        // more pharmacy
        $lats = [
            ["lat" => 23.710121, "lng" => 90.434302],
            ["lat" => 23.707842, "lng" => 90.429584],
            ["lat" => 23.707842, "lng" => 90.439409],
            ["lat" => 23.702655, "lng" => 90.435249],
        ];
        // more user
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'first_name' => 'mr',
                'last_name' => 'pharmacy' . ($i + 1),
                'user_name' => 'pharmacy' . ($i + 1),
                'email' => 'pharmacy' . ($i + 1) . '@gmail.com',
                'role_serial' => 4,
                'password' => Hash::make('12345678'),

                'contact_number' => '+934232532' . rand(4000, 9999) . $i,
                // 'lat' => $lats[$i]['lat'],
                // 'lng' => $lats[$i]['lng'],
                'lat' => "23.71" . rand(1000, 9999),
                'lng' => "90.43" . rand(1000, 9999),
                'dob' => '1978-02-14',
                'gender' => ['male','female'][rand(0,1)],
                'street' => 'faruk road 14/A',
                'city' => 'dhaka',
                'country' => 'bangladesh',
                'state' => 'bangladesh',
                'zip_code' => '1414',
            ]);
            $user->user_code = rand(100000, 999999) . $user->id;
            $user->save();
        }

        // more doctor
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'first_name' => 'mr',
                'last_name' => 'doctor' . ($i + 1),
                'user_name' => 'doctor' . ($i + 1),
                'email' => 'doctor' . ($i + 1) . '@gmail.com',
                'role_serial' => 3,
                'password' => Hash::make('12345678'),

                'contact_number' => '+934232532' . rand(4000, 9999) . $i,
                // 'lat' => '25.778522',
                // 'lng' => '88.897377',
                'lat' => "23.71" . rand(1000, 9999),
                'lng' => "90.43" . rand(1000, 9999),
                'dob' => '1978-02-14',
                'gender' => ['male','female'][rand(0,1)],
                'street' => 'faruk road 14/A',
                'city' => 'dhaka',
                'country' => 'bangladesh',
                'state' => 'bangladesh',
                'zip_code' => '1414',
            ]);
            $user->user_code = rand(100000, 999999) . $user->id;
            $user->save();
        }
    }
}
