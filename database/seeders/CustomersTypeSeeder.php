<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomersTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer_types = [];

        foreach (range(1, 5) as $value) {
            
            $customer_types[] = [
                'name' => "Customer $value",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('customer_types')->insert($customer_types);
    }
}
