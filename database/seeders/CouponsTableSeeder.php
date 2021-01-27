<?php

namespace Database\Seeders;
use App\Coupon;

use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    	$couponsRecords = [
        	[
        		'id' => 1,
        		'coupon_option' => 'Manual',
        		'coupon_code' => 'test10',
        		'categories' => '1,2',
        		'users' => 'shimulshaikh12@gmail.com,shimulshaikh12@gmail.com',
        		'coupon_type' => 'Single',
        		'amount_type' => 'Percentage',
        		'amount' => '10',
        		'expiry_date' => '2021-01-27',
        		'status' => 1
        	]
        ];

        Coupon::insert($couponsRecords);

    }
}
