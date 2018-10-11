<?php

use Illuminate\Database\Seeder;
use App\Winery;
use App\Ava;

class AvaWineryTableSeeder extends Seeder
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
        foreach ($data as $obj) {
            $wineryName = $obj->name;

            $winery = Winery::where('name','like', $wineryName)->first();

            $avaArray = explode(', ', $obj->ava);

            for($i=0; $i<15; $i++){
                if (isset($avaArray[$i])){
                    $ava = Ava::where('name','like',$avaArray[$i])->first();
                    $winery->avas()->save($ava);
                }
            }
    	}
    }
}
