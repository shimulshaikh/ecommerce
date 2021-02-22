<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\DeliveryAddress;

class DeliveryAddresseTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryRecords = [
        	[
        		'id' => 1,
        		'user_id' => 1,
        		'name' => 'Shimul shaikh',
        		'address' => 'Test12',
        		'city' => 'Dhaka',
        		'state' => 'Bangladesh',
        		'country' => 'Bangladesh',
        		'pincode' => '1100',
        		'mobile' => '0191243576',
        		'status' => 1
        	]
        ];

        DeliveryAddress::insert($deliveryRecords);
    }
}
