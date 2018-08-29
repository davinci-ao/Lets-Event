<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
          DB::table('events')->insert([
             'name' => str_random(10),
             'category_id' => rand(),
             'datum' => now(),
             'time' => date('Y-m-d H:i:s'),
             'price' => '10.00',
        	 'location_id' => rand(),
             'user_id' => rand(),
           ]);

    	// factory(App\Event::class, 50)->create();
    	// er is geen app\event 
    }
}
