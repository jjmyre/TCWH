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
    // Adapted from Laracasts tutorial "Favorite This: Part 1"
    public function run()
    {
        foreach(range(1, 100) as $index) {
            // randomly get winery_ids
            $winery = Winery::inRandomOrder()->first();
            $user = User::inRandomOrder()->first();
            $wishlists = $user->wishlists()->get();
            if($wishlists->contains('id', $winery->id)) {
                continue;
            }
            else {
                $user->wishlists()->attach($winery->id);
            }
            
        }
    }
}
