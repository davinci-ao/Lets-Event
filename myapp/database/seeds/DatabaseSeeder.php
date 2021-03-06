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
		DB::table('users')->insert([[
		    'student_nr' => "99021508",
		    'firstname' => "Peter",
		    'lastname' => "Verhaar",
		    'education_location_id' => "1",
		    'email' => "99021508@mydavinci.nl",
		    'password' => bcrypt('123456'),
		    'role' => "student",
		    'activated' => "not activated",
		    'remember_token' => str_random(10)
		    ], [
			  'student_nr' => "18328730",
			  'firstname' => "Dev",
			  'lastname' => "Test",
			  'education_location_id' => "3",
			  'email' => "Test@mydavinci.nl",
			  'password' => bcrypt('123456'),
			  'role' => "teacher",
			  'activated' => "activated",
			  'remember_token' => str_random(10)
		    ]]
		);


		DB::table('locations')->insert([
		    [
			  'name' => "Azzuro"
		    ], [
			  'name' => "Verde"
		    ], [
			  'name' => "Celeste"
		    ], [
			  'name' => "Bianco"
		    ]
		]);

		DB::table('categories')->insert([
		    [
			  'name' => "Yu-Gi-Oh@!"
		    ], [
			  'name' => "Schaken"
		    ], [
			  'name' => "Speuren"
		    ], [
			  'name' => "bejeweled"
		    ]
		]);
	}

}
