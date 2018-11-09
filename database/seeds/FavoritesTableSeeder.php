<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Winery;
use App\Favorite;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // Adapted from Laracasts tutorial "Favorite This: Part 1"

    public function run()
    {
        foreach(range(1, 100) as $index) {
        	// randomly get winery_ids
        	$winery = Winery::inRandomOrder()->first();

        	User::inRandomOrder()->first()->favorites()->attach($winery->id);

        }
        
    }
}
