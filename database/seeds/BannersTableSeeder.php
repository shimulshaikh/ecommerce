<?php

use Illuminate\Database\Seeder;
use App\Banner;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannersRecords = [
        	[ 'id' => 1,'image' => '','link' => '','title' => 'Black Jacket','alt' => 'Black Jacket','status' => 1 ],
        	[ 'id' => 2,'image' => '','link' => '','title' => 'Blue Jacket','alt' => 'Blue Jacket','status' => 1 ],
        	[ 'id' => 3,'image' => '','link' => '','title' => 'Red Jacket','alt' => 'Red Jacket','status' => 1 ],
        ];

        Banner::insert($bannersRecords);
    }
}
