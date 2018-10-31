<?php

/**
 * Description of ImportController
 *
 * @author Team yugioh
 */

namespace App\Http\Controllers;

use App\Http\Models\User;
use Illuminate\Http\Request;
use Validator;

class ImportController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Form to import CSV files.
	 * If CSV is invalid, shows error box.
	 * If data is imported into db, show succes box.
	 * @return type
	 */
	public function index()
	{
		return view('import.import');
	}

	public function processImport(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'student.*' => 'required|numeric',
			'firstName.*' => 'required|string',
			'prefix.*' => 'nullable|string',
			'lastName.*' => 'required|string'
		]);

		if ($validator->fails()) {
			return $validator->errors();
		}

		$csvData = [ [], [], [], [] ];

		$csvData = $this->prepareCsvData( $request->input('student', [] ), $csvData, 0);
		$csvData = $this->prepareCsvData( $request->input('firstName', [] ), $csvData, 1);
		$csvData = $this->prepareCsvData( $request->input('prefix', [] ), $csvData, 2);
		$csvData = $this->prepareCsvData( $request->input('lastName', [] ), $csvData, 3);

		$user = new user();
		$number = count($csvData[0]);

		for ($i = 0; $i < $number ; $i++) {
			$user->importCsvData( $csvData[0][$i] , $csvData[2][$i], $csvData[1][$i], $csvData[3][$i] );
		}

    	return response()->json( array('succes' => 'true', 'feedback' => 'The csv file is has been added to the database'), 200);
    }

    private function prepareCsvData($input, $array, $loop)
    {
    	foreach ($input as $key => $data) {
    		if ($key === 0) continue;	
			$array[$loop][] = $data;		
		}
		return $array;
    }

}
