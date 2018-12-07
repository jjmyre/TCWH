<?php

use Illuminate\Database\Seeder;
use App\Plan;

class PlansTableSeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	Plan::insert([
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
            'order' => 1,
	        'user_id' => 1,
	        'winery_id' => 1,
	    ]);

        Plan::insert([
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
            'order' => 2,
            'user_id' => 1,
            'winery_id' => 2,
        ]);

         Plan::insert([
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
            'order' => 2,
            'user_id' => 2,
            'winery_id' => 2,
        ]);

          Plan::insert([
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
            'order' => 2,
            'user_id' => 3,
            'winery_id' => 2,
        ]);
        

        
    }
}
