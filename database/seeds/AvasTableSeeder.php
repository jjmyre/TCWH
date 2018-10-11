<?php

use Illuminate\Database\Seeder;
use App\Ava;

class AvasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {   /*
        http://www.fullstack4u.com/laravel/laravel-5-load-seed-data-from-json/
        */
        
        // Retrieve the JSON for avas info
        $json = File::get("database/data/avas.json");
        
        // Decode JSON
        $data = json_decode($json); 

        // Iterate over decoded json
        foreach ($data as $ava) {
            Ava::insert([
                'created_at' => Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
                'name' => $ava->name,
                'description' => $ava->description,
                'info_url' => $ava->info_url,
                'css_class' => $ava->css_class,
            ]);
        }
    }
}