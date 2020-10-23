<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Factory::create();
    	DB::table('users')->truncate();
        DB::table('users')->insert([
        	[
				'name' => $faker->unique()->name,
				'email' => $faker->unique()->email,
				'role_id' => 1,
				'city' => $faker->city,
				'avatar' => 'no-men.png',
				'password' => Hash::make('test1234'),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
        	],
        	[
				'name' => $faker->unique()->name,
				'email' => $faker->unique()->email,
				'role_id' => 2,
				'city' => $faker->city,
				'avatar' => 'no-men.png',
				'password' => Hash::make('test1234'),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
        	],
        	[
				'name' => $faker->unique()->name,
				'email' => $faker->unique()->email,
				'role_id' => 2,
				'city' => $faker->city,
				'avatar' => 'default.jpg',
				'password' => Hash::make('test1234'),
				'created_at' => Carbon::now(),
				'updated_at' => Carbon::now(),
        	],
	    ]);
    }
}
