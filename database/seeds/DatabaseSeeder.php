<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Disable guard for seeder
        Eloquent::unguard();

        $this->call(AvasTableSeeder::class);
        $this->call(WineriesTableSeeder::class);
        $this->call(AvaWineryTableSeeder::class);
        $this->call(TimesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(FavoritesTableSeeder::class);
        $this->call(WishlistsTableSeeder::class);
    }
}
