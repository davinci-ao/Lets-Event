<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ImportCsv extends Model
{
	protected $table = 'users';
	protected $fillable = ['student_nr', 'firstname', 'lastname', 'education_location_id', 'email', 'password'];

	//save csv to DB
    public function saveCsv($csvArray) {
        try {
        	DB::table('users')->insert(
        		['student_nr' => $csvArray[0], 'firstname' => $csvArray[1], 'lastname' => $csvArray[2], 'education_location_id' => 0, 'email' => $csvArray[3], 'password' => '']
        	);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    //tmp save to session
    public function tmpSaveCsv($request, $csvArray) {
    	$request->session()->put('csv', $csvArray);
    }

    //get tmp csv from session
    public function getTmpCsv($request) {
    	return $request->session()->get('csv');
    }
}
