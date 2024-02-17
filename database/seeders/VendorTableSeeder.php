<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords = [
            ['id'=>1,
            'name' => 'john',
            'address' => 'deuteronomy',
            'city' => 'ilaro',
            'state'=>'ogun state',
            'country' => 'Nigeria',
            'pincode' => '11022',
            'mobile' => '09015324851',
            'email'=>'kudastech@gmail.com',
            'status'=>0]
        ];

        Vendor::insert($vendorRecords);
    }
}
