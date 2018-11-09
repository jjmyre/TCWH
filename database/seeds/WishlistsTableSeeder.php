<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Winery;
use App\Wishlist;

class WishlistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Adapted from Laracasts tutorial "Favorite This: Part 1"
        foreach(range(1, 100) as $index) {
        	// randomly get winery_ids
        	$winery = Winery::inRandomOrder()->first();

        	User::inRandomOrder()->first()->wishlists()->attach($winery->id);
        }
    }
}
