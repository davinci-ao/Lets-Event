<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\locations;
use Validator;

/**
 * Description of EventsController
 *
 * @author Ian Storm
 */
class EventsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	private $eventStatus;
	
	/**
	 * Loads the web page with the corresponding parameter value supplied from $parra
	 * @param type $parra
	 * @return type view
	 */
	public function index()
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
	

	/**
	 *  Gives the event model the data from the form POST
	 */
	public function createEvent(Request $request)
	{	
		$eventData = $_POST;
		$validator = Validator::make($request->all(), [
            'eventName' => 'required',
            'eventDate' => 'required|date',
            'eventTime' => 	['required',
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
					return $fail('YOU LIED TO ME!:This location doesn\'t exsist');
				}
        	}],
        ]);
     
        if ($validator->fails()) {
        	$this->eventStatus = false;
            $this->index();
        }

		$event = new Event();
		if (empty($eventData['eventPrice'])) $eventData['eventPrice'] = 0;
		$result = $event->saveEventData($eventData);
			
		$this->eventStatus = $result;
		return $this->index();
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
