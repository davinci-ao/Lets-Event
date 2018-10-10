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
			  'name' => "Yu-Gi-Oh@!"
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

			  'name' => 'Bord spellen avond 2.0',
			  'category_id' => '0',
			  'datum' => '2018-10-05',
			  'time' => '20:00:00',
			  'location_id' => '1',
			  'minimum_members' => 1,
			  'maximum_members' => null,
			  'price' => '0',
			  'status' => 'accepted',
			  'description' => '',
			  'user_id' => '1',
			  'minimum_members' => 0,
			  'maximum_members' => 0
		    ], [
			  'name' => 'Bord spellen avond',
			  'datum' => '2018-10-15',
			  'location_id' => '1',
			  'time' => '20:00:00',
			  'minimum_members' => 1,
			  'maximum_members' => null,
			  'price' => '5',
			  'status' => 'accepted',
			  'description' => 'Gezelig een dachtje uit',
			  'user_id' => '1'
		    ], [
			  'name' => 'Yu-Gi-Oh! YCS',
			  'category_id' => '0',
			  'datum' => '2018-12-31',
			  'location_id' => '1',
			  'time' => '20:00:00',
			  'minimum_members' =>12,
			  'maximum_members' => 2500,
			  'price' => '20',
			  'status' => 'accepted',
			  'description' => 'YUGIOH! YCS DORDRECHT pre registers get sick loot',
			  'user_id' => '2'
		    ], [
			  'name' => 'Vanguard Championship Davinci',
			  'category_id' => '0',
			  'datum' => '2022-01-22',
			  'location_id' => '1',
			  'time' => '08:30:00',
			  'minimum_members' => 20,
			  'maximum_members' => 40000,
			  'price' => '18',
			  'status' => 'accepted',
			  'description' => 'VANGUARD ! YAEH !',
			  'user_id' => '1'
		    ], [
			  'name' => 'Help ian zn kaarten te soorteren',
			  'category_id' => '0',
			  'datum' => '2018-10-15',
			  'location_id' => '1',
			  'time' => '20:00:00',
			  'minimum_members' => 1,
			  'maximum_members' => null,
			  'price' => '0',
			  'status' => 'accepted',
			  'description' => 'hij moet zn kaarten een keer sorteren',
			  'user_id' => '2'

		    ]
		]);
	}

}
