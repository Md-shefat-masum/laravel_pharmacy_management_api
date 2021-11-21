<?php

namespace Database\Seeders;

use App\Models\Drug;
use Illuminate\Database\Seeder;

class DrugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Drug::insert([
            'pharmacy_id' => 4,
            'name' => 'Flexi',
            'photo' => '',
            'photoURL' => 'http://www.squarepharma.com.bd/products/tylace_l.jpg',
            'category_id' => 1,
            'manufacturer_id' => 1,
            'storage_location_id' => 1,
            'supplier_id' => 1,
            'need_prescription' => rand(0,1),
            'scientific_name' => 'Flexi',
            'storage_temperature' => 20,
            'dangerous_level' => 'low',
            'no_of_unit_in_package' => 10,
            'unit_price' => rand(50,200),
        ]);
        Drug::insert([
            'pharmacy_id' => 4,
            'name' => 'Tylace',
            'photo' => '',
            'photoURL' => 'http://www.squarepharma.com.bd/products/tylace_l.jpg',
            'category_id' => 2,
            'manufacturer_id' => 2,
            'storage_location_id' => 2,
            'supplier_id' => 1,
            'need_prescription' => rand(0,1),
            'scientific_name' => 'Flexi',
            'storage_temperature' => 20,
            'dangerous_level' => 'low',
            'no_of_unit_in_package' => 10,
            'unit_price' => rand(50,200),
        ]);
        Drug::insert([
            'pharmacy_id' => 4,
            'name' => 'Virux',
            'photo' => '',
            'photoURL' => 'http://www.squarepharma.com.bd/products/VIRUX.jpg',
            'category_id' => 3,
            'manufacturer_id' => 3,
            'storage_location_id' => 3,
            'supplier_id' => 1,
            'need_prescription' => rand(0,1),
            'scientific_name' => 'Flexi',
            'storage_temperature' => 20,
            'dangerous_level' => 'low',
            'no_of_unit_in_package' => 10,
            'unit_price' => rand(50,200),
        ]);
        Drug::insert([
            'pharmacy_id' => 4,
            'name' => 'Virux Tablet',
            'photo' => '',
            'photoURL' => 'http://www.squarepharma.com.bd/products/Virux-200_l.jpg',
            'category_id' => 4,
            'manufacturer_id' => 4,
            'storage_location_id' => 4,
            'supplier_id' => 1,
            'need_prescription' => rand(0,1),
            'scientific_name' => 'Flexi',
            'storage_temperature' => 20,
            'dangerous_level' => 'low',
            'no_of_unit_in_package' => 10,
            'unit_price' => rand(50,200),
        ]);
        Drug::insert([
            'pharmacy_id' => 4,
            'name' => 'Virux',
            'photo' => '',
            'photoURL' => 'http://www.squarepharma.com.bd/products/virux_hc_l.jpg',
            'category_id' => 5,
            'manufacturer_id' => 5,
            'storage_location_id' => 5,
            'supplier_id' => 1,
            'need_prescription' => rand(0,1),
            'scientific_name' => 'Flexi',
            'storage_temperature' => 20,
            'dangerous_level' => 'low',
            'no_of_unit_in_package' => 10,
            'unit_price' => rand(50,200),
        ]);
    }
}
