<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();

        $adminRecords = [
        	[
        		'id' => 1,
        		'name' => 'admin',
        		'type' => 'admin',
        		'mobile' => '01923349851',
        		'email' => 'admin@gmail.com',
        		'password' => '$2y$10$TbKwaPrOl/C8Don4AzSlqu3Fn1NTrgqBi8lzrrFPassxaAFYFUhzq',
        		'image' => '',
        		'status' => 1
        	],

        	[
        		'id' => 2,
        		'name' => 'subadmin',
        		'type' => 'subadmin',
        		'mobile' => '01923349851',
        		'email' => 'subadmin@gmail.com',
        		'password' => '$2y$10$TbKwaPrOl/C8Don4AzSlqu3Fn1NTrgqBi8lzrrFPassxaAFYFUhzq',
        		'image' => '',
        		'status' => 1
        	],
        ];

        DB::table('admins')->insert($adminRecords);

        // foreach ($adminRecords as $key => $record) {
        // 	\App\Admin::create($record);
        // }
    }
}
