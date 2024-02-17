<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VendorsBankDetails extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords = [
            [
                'id' => 1,
                'vendor_id'=> 1,
                'account_holder_name'=> 'Arike Preorder',
                'bank_name'=>'kudastech',
                'account_number' => '0901537323',
                'bank_ifsc_code' => '23424212',
                // 'shop_state' => 'ogun state',
                // 'shop_country' => 'Nigeria',
                // 'shop_pincode' => '102001',
                // 'shop_mobile' => '09015324851',
                // 'shop_website' => 'kudastech.com',
                // 'shop_email' => 'kudastech@gmail.com',
                // 'address_proof' => 'passport',
                // 'address_proof_image' => 'test.jpg',
                // 'business_license_number' => '1234567',
                // 'gst_number' => '324323',
                // 'pan_number' => '123456',
                // 'gst_number' => 'ilaro',

            ]
        ];

        VendorsBankDetail::insert($vendorRecords);
    }
}
