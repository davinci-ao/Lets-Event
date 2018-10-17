<?php

/**
 * Description of ImportController
 *
 * @author Team yugioh
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Models\ImportCsv;

class ImportController extends Controller
{

	const COL_STUDENT_NR = 'student_nr';
	const COL_FIRSTNAME = 'firstname';
	const COL_LASTNAME = 'lastname';
	const COL_PREFIX = 'prefix';
	const COL_EMAIL = 'email';

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
		return view('importCSV');
	}

	public function errorParseImport(Request $request)
	{
		$importCsv = new ImportCsv;
		if (null == $importCsv->getTmpCsv($request)) {
			return view('importCSV');
		}
		$db_fields = array(self::COL_STUDENT_NR, self::COL_FIRSTNAME, self::COL_PREFIX, self::COL_LASTNAME);
		return view('import_fields', ['csv_data' => $importCsv->getTmpCsv($request), 'db_fields' => $db_fields]);
	}

	/**
	 * Checks if file is CSV.
	 * Then tries to read it.
	 * Returns to index if not CSV or invalid CSV.
	 * Else continue to import_fields view.
	 * @param Request $request
	 * @return type
	 */
	public function parseImport(Request $request)
	{
		$db_fields = array(self::COL_STUDENT_NR, self::COL_FIRSTNAME, self::COL_PREFIX, self::COL_LASTNAME);
		$importCsv = new ImportCsv;
		$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		if (isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
			$arr_file = explode('.', $_FILES['file']['name']);
			$extension = end($arr_file);

			if ($extension == 'csv') {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				return redirect('importcsv')->with('status', 'Not a CSV file!');
			}

			try {
				$spreadsheet = $reader->load($_FILES['file']['tmp_name']);
			} catch (\Exception $e) {
				return redirect('importcsv')->with('status', 'Invalid CSV file!');
			}

			$sheetData = $spreadsheet->getActiveSheet()->toArray();

			$importCsv->tmpSaveCsv($request, $sheetData);
			return view('import_fields', ['csv_data' => $sheetData, 'db_fields' => $db_fields]);
		} else {
			return back()->with('status', 'This is not a CSV file!');
		}
	}

	/**
	 *  Process the data to insert it into the Database
	 * 
	 * @param Request $request
	 * @return view index if success else return error
	 */
	public function processImport(Request $request)
	{

		$importCsv = new ImportCsv;
		$csvData = $importCsv->getTmpCsv($request);

		if ($csvData === null || route('import_parse') !== \URL::previous()) {
			return back();
		}

		if (!in_array('0', $_POST['fields']) || !in_array('1', $_POST['fields']) || !in_array('2', $_POST['fields']) || !in_array('3', $_POST['fields']) || count($_POST['fields']) != 4) {
			return redirect('/errorparseimport')->with('status', 'Error! Make sure there is one of each fields set. No more or less.');
		}

		$csvData = array_slice($csvData, 1);

		$newArray = array();
		for ($i = 0; $i < 4; $i++) {
			$newArray[$i] = array_search($i, $_POST['fields']);
		}

		foreach ($csvData as $data) {
			$dbData = array();

			// first name
			for ($i = 0; $i < count($newArray); $i++) {
				$db_field = $newArray[$i];
				$dbData[] = $data[$db_field];
			}
			//prefix + last name or lastname only
			if ($dbData[2] != null) {
				$dbData[2] = $dbData[2] . ' ' . $dbData[3];
			} else {
				$dbData[2] = $dbData[3];
			}

			// email
			$dbData[3] = $dbData[0] . '@mydavinci.nl';

			$errors = $this->validateRowData($dbData);
			if (empty($errors)) {
				$importCsv->saveCsv($dbData);
			}
		}

		return redirect('importcsv')->with('status', 'success');
	}

	/**
	 * Validate data in this CSV row.
	 * 
	 * @param $rowData data to validate
	 * @return $errors validation errors
	 */
	private function validateRowData($rowData)
	{
		$validationData = array();
		$validationData[self::COL_STUDENT_NR] = $rowData[0];
		$validationData[self::COL_FIRSTNAME] = $rowData[1];
		$validationData[self::COL_LASTNAME] = $rowData[2];
		$validationData[self::COL_EMAIL] = $rowData[3];

		$validator = Validator::make($validationData, [
			  self::COL_STUDENT_NR => 'required|integer',
			  self::COL_FIRSTNAME => 'required|string',
			  self::COL_LASTNAME => 'required|string',
			  self::COL_EMAIL => 'required|email'
		]);

		if ($validator->fails()) {
			return $validator->errors();
		}

		return null;
	}

}
