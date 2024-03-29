<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(AdminsTableSeeder::class);
        //$this->call(SectionTableSeeder::class);
        //$this->call(CategoryTableSeeder::class);
        //$this->call(ProductTableSeeder::class);
        //$this->call(ProductAttributeTableSeeder::class);
        //$this->call(productsImagesTableSeeder::class);
        //$this->call(BrandsTableSeeder::class);
        //$this->call(BannersTableSeeder::class);
        //$this->call(CouponsTableSeeder::class);
        //$this->call(DeliveryAddresseTablesSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
    }
}
