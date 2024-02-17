<?php

namespace Database\Seeders;

// use App\Http\Models\Admin;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRecords = [
            ['id'=> 2,
            'name'=> 'John',
            'type' => 'vendor',
            'vendor_id' => 1,
            'mobile' => '09015324851',
            'email' => 'johnsuperadmin@gmail.com',
            'password' => '$2a$12$VqY.tJzrvvF7gp5yL9YMxuy6onCw.ulKvJibhmQE1pyc8p5n9vTrS',
            'image'=> '',
            'status' => 0,
        ]
        ];

        Admin::insert($adminRecords);
    }
}
