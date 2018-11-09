<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Winery;
use App\Visit;

class VisitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Adapted from Laracasts tutorial "Favorite This: Part 1"
        foreach(range(1, 20) as $index) {
        	// randomly get winery_ids
        	$winery = Winery::inRandomOrder()->first();

        	User::inRandomOrder()->first()->visits()->attach($winery->id);
        }
        
    }
}

