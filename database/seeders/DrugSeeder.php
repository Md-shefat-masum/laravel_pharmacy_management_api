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
        $drug = Drug::create([
            'pharmacy_id' => 4,
            'name' => 'Flexi',
            'photo' => '',
            'photoURL' => 'http://www.squarepharma.com.bd/products/tylace_l.jpg',
            'need_prescription' => rand(0,1),
            'scientific_name' => 'Flexi',
            'storage_temperature' => 20,
            'dangerous_level' => 'low',
            'no_of_unit_in_package' => 10,
            'unit_price' => rand(50,200),
            'sales_price' => rand(50,200),
            'sales_tax' => rand(5,12),
        ]);
        $drug->related_categories()->attach([rand(1,3),rand(4,5)]);
        $drug->related_drug_manufacturer()->attach([rand(1,3),rand(4,5)]);
        $drug->related_drug_storage()->attach([rand(1,3),rand(4,5)]);
        $drug->related_user_supplier()->attach([rand(1,3),rand(4,5)]);


        $drug = Drug::create([
            'pharmacy_id' => 4,
            'name' => 'Tylace',
            'photo' => '',
            'photoURL' => 'http://www.squarepharma.com.bd/products/tylace_l.jpg',
            'need_prescription' => rand(0,1),
            'scientific_name' => 'Flexi',
            'storage_temperature' => 20,
            'dangerous_level' => 'low',
            'no_of_unit_in_package' => 10,
            'unit_price' => rand(50,200),
            'sales_price' => rand(50,200),
            'sales_tax' => rand(5,12),
        ]);
        $drug->related_categories()->attach([rand(1,3),rand(4,5)]);
        $drug->related_drug_manufacturer()->attach([rand(1,3),rand(4,5)]);
        $drug->related_drug_storage()->attach([rand(1,3),rand(4,5)]);

        $drug = Drug::create([
            'pharmacy_id' => 4,
            'name' => 'Virux',
            'photo' => '',
            'photoURL' => 'http://www.squarepharma.com.bd/products/VIRUX.jpg',
            'need_prescription' => rand(0,1),
            'scientific_name' => 'Flexi',
            'storage_temperature' => 20,
            'dangerous_level' => 'low',
            'no_of_unit_in_package' => 10,
            'unit_price' => rand(50,200),
            'sales_price' => rand(50,200),
            'sales_tax' => rand(5,12),
        ]);
        $drug->related_categories()->attach([rand(1,3),rand(4,5)]);
        $drug->related_drug_manufacturer()->attach([rand(1,3),rand(4,5)]);
        $drug->related_drug_storage()->attach([rand(1,3),rand(4,5)]);

        $drug = Drug::create([
            'pharmacy_id' => 4,
            'name' => 'Virux Tablet',
            'photo' => '',
            'photoURL' => 'http://www.squarepharma.com.bd/products/Virux-200_l.jpg',
            'need_prescription' => rand(0,1),
            'scientific_name' => 'Flexi',
            'storage_temperature' => 20,
            'dangerous_level' => 'low',
            'no_of_unit_in_package' => 10,
            'unit_price' => rand(50,200),
            'sales_price' => rand(50,200),
            'sales_tax' => rand(5,12),
        ]);
        $drug->related_categories()->attach([rand(1,3),rand(4,5)]);
        $drug->related_drug_manufacturer()->attach([rand(1,3),rand(4,5)]);
        $drug->related_drug_storage()->attach([rand(1,3),rand(4,5)]);

        $drug = Drug::create([
            'pharmacy_id' => 4,
            'name' => 'Virux',
            'photo' => '',
            'photoURL' => 'http://www.squarepharma.com.bd/products/virux_hc_l.jpg',
            'need_prescription' => rand(0,1),
            'scientific_name' => 'Flexi',
            'storage_temperature' => 20,
            'dangerous_level' => 'low',
            'no_of_unit_in_package' => 10,
            'unit_price' => rand(50,200),
            'sales_price' => rand(50,200),
            'sales_tax' => rand(5,12),
        ]);
        $drug->related_categories()->attach([rand(1,3),rand(4,5)]);
        $drug->related_drug_manufacturer()->attach([rand(1,3),rand(4,5)]);
        $drug->related_drug_storage()->attach([rand(1,3),rand(4,5)]);

    }
}
