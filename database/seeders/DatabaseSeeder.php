<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use ServicesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
    	$this->call([
    		'Database\Seeders\UserTableSeeder',
            'Database\Seeders\ServicesTableSeeder',
    	]);

        echo 'success <a href="'.route("request").'">home</a>';
    }
}
