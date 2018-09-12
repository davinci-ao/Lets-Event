<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Event;
use App\locations;
use Validator;

class EventController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	private $eventStatus;

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	// show all events
	public function index()
	{
		$events = DB::table('events')->get();
		return view('events', ['events' => $events]);
	}

	public function create()
	{
		$locations = new locations();
		$locations = $locations::all();

		if ($this->eventStatus === true) {
			$this->eventStatus = null;
			return view('event', ['locations' => $locations, 'status' => 'success']);
		}
		if ($this->eventStatus === false) {
			$this->eventStatus = null;
			return view('event', ['locations' => $locations, 'status' => 'fail']);
		}
		return view('event', ['locations' => $locations, 'status' => '']);
	}

	public function createSave(Request $request)
	{
		$eventData = $_POST;
		$validator = Validator::make($request->all(), [
			  'eventName' => 'required',
			  'eventDate' => 'required|date',
			  'eventTime' => ['required',
				function($attribute, $value, $fail) {
					$time = \DateTime::createFromFormat('G:i:s', $value);
					if ($time == false) {
						return $fail("YOU LIED TO ME!:Your time is invalid.");
					}
				}],
			  'eventPrice' => 'nullable|regex:/^[0-9]*\.?[0-9]{1,2}+$/',
			  'eventLocation' => ['required',
				'numeric',
				function($attribute, $value, $fail) {
					$locations = new locations();
					$locations = $locations::find($value);
					if (!isset($locations->id)) {
						return $fail('YOU LIED TO ME!:This location doesn\'t exist');
					}
				}],
		]);

		if ($validator->fails()) {
			$this->eventStatus = false;
			$this->create();
		}

		$event = new Event();
		if (empty($eventData['eventPrice']))
			$eventData['eventPrice'] = 0;
		$result = $event->saveEventData($eventData);

		$this->eventStatus = $result;
		return $this->create();
	}

	/**
	 * 
	 */
	public function editEvent()
	{
		
	}

	/**
	 * 
	 */
	public function deleteEvent()
	{
		
	}

}
