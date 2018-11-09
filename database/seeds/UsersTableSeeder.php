<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // Adapted from Laracasts tutorial "Favorite This: Part 1"
    public function run()
    {
    	//assign variable for Faker Package
    	$faker = Faker\Factory::create();

    	User::insert([
        		'username' => 'testuser',
        		'email' => 'testemail@harvard.edu',
        		'password' => Hash::make("harvard")
        	]);

        foreach(range(2, 30) as $index) {

        	User::insert([
        		'username' => $faker->firstName($gender = 'male'|'female'),
        		'email' => $faker->email,
        		'password' => Hash::make("harvard")
        	]);
        }
    }
}
