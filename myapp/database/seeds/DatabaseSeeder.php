<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
<<<<<<< HEAD

	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		// DB::table('users')->insert([[
		//     'student_nr' => "99021508",
		//     'firstname' => "Peter",
		//     'lastname' => "Verhaar",
		//     'education_location_id' => "1",
		//     'email' => "99021508@mydavinci.nl",
		//     'activation_token' => "str_random(10)",
		//     'email_send_at' => "2018-09-15",
		//     'password' => bcrypt('123456'),
		//     'role' => "leerling",
		//     'activated' => "geactivateerd",
		//     'remember_token' => "str_random(10)"
		//     ], [
		// 	  'student_nr' => "18328730",
		// 	  'firstname' => "Dev",
		// 	  'lastname' => "Test",
		// 	  'education_location_id' => "3",
		// 	  'email' => "Test@mydavinci.nl",
		// 	  'activation_token' => "str_random(10)",
		// 	  'email_send_at' => "2018-09-15",
		// 	  'password' => bcrypt('123456'),
		// 	  'role' => "leeraar",
		// 	  'activated' => "geactivateerd",
		// 	  'remember_token' => "str_random(10)"
		//     ]]
		// );

		// DB::table('locations')->insert([[
		// 	 'name' => "Azzuro"
		//     ], [
		// 	  'name' => "Verde"
		//     ], [
		// 	  'name' => "Celeste"
		//     ], [
		// 	  'name' => "Bianco"
		//     ]
		// ]);

		DB::table('categories')->insert([
            'name' => str_random(10),
        ]);
	}

=======
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
    }
>>>>>>> 0582cf575fdf7ff05d23d16bbc6f5181c4c98334
}
