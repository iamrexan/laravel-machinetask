<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class ServicesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Factory::create();
    	DB::table('services')->truncate();
    	DB::table('bookings')->truncate();
    	DB::table('booking_slots')->truncate();
    	$rrn = random_int(3, 5);
    	$thumnail_arr = ['dance.jpg', 'training.png', 'yogo.png'];
    	for ($i=0; $i < $rrn; $i++) {
    		$serviceId = DB::table('services')->insertGetId(
	        	[
	        		'user_id' => 1,
	        		'title' => $faker->sentence(3),
	        		'description' => $faker->text,
	        		'thumnail_url' => $thumnail_arr[random_int(0, 2)],
	        		'type' => $this->randomType(),
	        		'price' => $faker->randomFloat(2),
	        		'currency_id' => 1,
	        		'price_type' => 1,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
	        	]);
    		$this->createBookings($serviceId);
    	}
    }

    public function randomType() {
    	$type = ['FITNESS', 'DANCE', 'CULTURE', "COOKING", 'TEST'];

    	return $type[random_int(0, 4)];
    }

    public function createBookings($serviceId) {
    	if (!is_null($serviceId)) {
	    	$faker = Factory::create();
	    	$timing = ['09:00 AM - 02:00 PM', '10:00 AM - 06:00 PM', '08:00 AM - 12:00 PM'];
	    	$bookings = random_int(1, 3);
	    	$user_d = random_int(2, 3);
	    	for ($i=0; $i < $bookings; $i++) { 
		        $bookingId = DB::table('bookings')->insertGetId([
		        	'user_id' => $user_d,
		        	'service_id' => $serviceId,
		        	'address' => $faker->address,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
		        ]);
		        $randomSlot = random_int(1, 3);
		        $arr = [];
		        for ($j=0; $j < $randomSlot; $j++) { 
		        	$arr[] = [
		        		'booking_id' => $bookingId,
		        		'slot_date' => Carbon::parse($faker->dateTimeBetween('now', '1 month')),
		        		'slot_timing' => $timing[random_int(0,2)],
		        	];
		        }
		        DB::table('booking_slots')->insert($arr);
	    	}
    	}
    }
}
