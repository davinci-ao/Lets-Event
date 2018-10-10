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
		    'role' => "leerling",
		    'activated' => "geactivateerd",
		    'remember_token' => str_random(10)
		    ], [
			  'student_nr' => "18328730",
			  'firstname' => "Dev",
			  'lastname' => "Test",
			  'education_location_id' => "3",
			  'email' => "Test@mydavinci.nl",
			  'password' => bcrypt('123456'),
			  'role' => "leeraar",
			  'activated' => "geactivateerd",
			  'remember_token' => str_random(10)
		    ]]
		);


		DB::table('locations')->insert([[
		    'name' => "Azzuro"
		    ], [
			  'name' => "Verde"
		    ], [
			  'name' => "Celeste"
		    ], [
			  'name' => "Bianco"
		    ]
		]);

		DB::table('categories')->insert([[
		    'name' => "Yu-Gi-Oh"
		    ], [
			  'name' => "Schaken"
		    ], [
			  'name' => "Speuren"
		    ], [
			  'name' => "bejeweled"
		    ]
		]);

		DB::table('events')->insert([
		    [
			  'name' => 'Bord spellen avond',
			  'datum' => '2018-10-05',
			  'time' => '20:00:00',
			  'location_id' => '1',
			  'price' => '0',
			  'description' => '',
			  'user_id' => '1',
			  'minimum_members' => 0,
			  'maximum_members' => 0
		    ], [
			  'name' => 'Bord spellen avond',
			  'datum' => '2018-10-15',
			  'location_id' => '1',
			  'time' => '20:00:00',
			  'price' => '5',
			  'description' => 'Gezelig een dachtje uit',
			  'user_id' => '1',
			  'minimum_members' => 1,
			  'maximum_members' => 15
		    ]
		]);
	}

}
