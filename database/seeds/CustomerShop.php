<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CustomerShop extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $gender = $faker->randomElement(['male', 'female']);

    	foreach (range(1,50) as $index) {
            $year = rand(2009, 2016);
            $month = rand(1, 12);
            $day = rand(1, 28);
            $hour = rand(1,23);
            $minute = rand(1,59);
            $sec = rand(1,59);

            $date = Carbon::create($year,$month ,$day , $hour, $minute, $sec);

            DB::table('customer_shops')->insert([
                'shop_name' => $faker->name($gender),
                'shop_address' => $faker->address,
                'shop_province_id' => $faker->numberBetween(1,77),
                'shop_amphur_id' => $faker->numberBetween(1,993),
                'shop_district_id' => $faker->numberBetween(1,8860),
                'shop_zipcode' => $faker->numberBetween(10000,99999),
                'shop_profile_image' => '',
                'shop_fileupload' => '', 
                'shop_status' => '0',
                'employee_id' => $faker->numberBetween(1,50),
                'created_by' => $faker->numberBetween(1,50),
                'updated_by' => '',
                'deleted_by' => '',
                'created_at' => $date->format('Y-m-d H:i:s'),
                'updated_at' => $date->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
