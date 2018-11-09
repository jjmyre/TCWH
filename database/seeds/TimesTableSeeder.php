<?php

use Illuminate\Database\Seeder;
use App\Time;
use App\Winery;

class TimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
    	/*
		http://www.fullstack4u.com/laravel/laravel-5-load-seed-data-from-json/
        */
        $json = File::get("database/data/wineries.json");
        // Decode JSON data
        $data = json_decode($json);

        // Iterate over decoded json
        foreach ($data as $winery) {
            $wineryName = $winery->name; 
            $winery_id = Winery::where('name', '=', $wineryName)->pluck('id')->first();
	        
            Time::insert([
        		'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            	'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
            	'monday' => $winery->monday,
            	'tuesday' => $winery->tuesday,
            	'wednesday' => $winery->wednesday,
            	'thursday' => $winery->thursday,
            	'friday' => $winery->friday,
            	'saturday' => $winery->saturday,
            	'sunday' => $winery->sunday,
                'winery_id' => $winery_id,
	    	]);
   		}
   	}
}
