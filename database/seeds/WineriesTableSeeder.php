<?php

use Illuminate\Database\Seeder;
use App\Winery;

class WineriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// Retrieve the JSON for wineries info
        $json = File::get("database/data/wineries.json");
        
        // Decode JSON
        $data = json_decode($json); 

        // Iterate over decoded json
        foreach ($data as $winery) {
	        Winery::insert([
                'created_at' => Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
                'name' => $winery->name,
		        'sub_name' => $winery->sub_name,
		        'region' => $winery->region,
		        'sub_region' => $winery->sub_region,
                'street' => $winery->street,
                'city' => $winery->city,
                'state' => $winery->state,
                'zip' => $winery->zip,
		        'phone' => $winery->phone,
		        'email' => $winery->email,
		        'web_url' => $winery->web_url,
		        'dining' => $winery->dining,
		        'note' => $winery->note,
                'logo' => $winery->logo,
	    	]);
   		}
    }
}
