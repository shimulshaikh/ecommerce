<?php

use Illuminate\Database\Seeder;
use App\ProductsImage;

class productsImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsImageRecords = [
        	[ 'id' => 1,'product_id'=>1,'image' => '-2020-12-19-5fdd89c82fb37.png','status' => 1 ],
        ];

        ProductsImage::insert($productsImageRecords);
    }
}
