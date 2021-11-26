<?php

namespace Database\Seeders;

use App\Models\UserSupplier as ModelsUserSupplier;
use Illuminate\Database\Seeder;

class UserSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsUserSupplier::create([
            'pharmacy_id' => 4,
            'supplier_name' => 'AD Brook',
            'company_name' => 'Lab Aid',
            'contact_number' => '+8923223214',
            'email' => 'supplier1@pharma.com',
            'address' => 'north america, street 4',
            'city' => 'dragon gate',
        ]);
        ModelsUserSupplier::create([
            'pharmacy_id' => 4,
            'supplier_name' => 'Tony stark',
            'company_name' => 'Stark Ltd',
            'contact_number' => '+8923223214',
            'email' => 'stark@pharma.com',
            'address' => 'north america, street 4',
            'city' => 'dragon gate',
        ]);
        ModelsUserSupplier::create([
            'pharmacy_id' => 4,
            'supplier_name' => 'Nic Fury',
            'company_name' => 'Fury LSD Ltd',
            'contact_number' => '+8923223214',
            'email' => 'fury@pharma.com',
            'address' => 'north america, street 4',
            'city' => 'dragon gate',
        ]);
    }
}
